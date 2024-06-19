<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('completed_at')
            ->orderBy('id', 'DESC')
            ->get();

        $tasks = Task::where('user_id', Auth::id())->get();

        return view('user.home', ['tasks' => $tasks]);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        try {
            $validateTask = Validator::make($request->all(), [
                'title' => 'required|max:500',
                'description' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // if ($validateTask->fails()) {
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'Validation Error !',
            //         'errors' => $validateTask->errors(),
            //     ], 401);
            // }

            if ($validateTask->fails()) {
                return redirect()->back()->withErrors($validateTask)->withInput();
            }

            $imagePath = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('uploads/tasks', $imageName, 'public');
            }

            Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => Auth::id(),
                'image' => $imagePath,
            ]);

            return redirect()->route('home')->with('success', 'Create Task Successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function complete($id)
    {
        try {
            $task = Task::where('id', $id)->first();

            $task->completed_at = now();
            $task->save();

            return redirect()->route('home')->with('success', 'Complete Task Successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);

        return view('user.edit', compact('task'));
    }

    public function update(Request $request)
    {
        try {
            $validateTask = Validator::make($request->all(), [
                'title' => 'required|max:500',
                'description' => 'required',
            ]);

            if ($validateTask->fails()) {
                return redirect()->back()->withErrors($validateTask)->withInput();
            }

            $task = Task::findOrFail($request->id);
            $task->update($request->all());

            return redirect()->route('home')->with('success', 'Task updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $task = Task::where('id', $id)->first();

            $task->delete();

            return redirect()->route('home')->with('success', 'Delete Task Successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}

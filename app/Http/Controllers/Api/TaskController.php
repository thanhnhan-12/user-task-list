<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Task::where('user_id', Auth::id());

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $tasks = $query->orderBy('created_at', 'DESC')->paginate(6);

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
                'image' => 'required|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            // php artisan storage:link
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
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validateTask->fails()) {
                return redirect()->back()->withErrors($validateTask)->withInput();
            }

            $task = Task::findOrFail($request->id);

            if ($request->hasFile('image')) {
                // Delete old Image
                if ($task->image) {
                    Storage::disk('public')->delete($task->image);
                }

                // Storage Image
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('uploads/tasks', $imageName, 'public');

                // Update image path
                $task->image = $imagePath;
            }

            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $task->image,
            ]);

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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        return view("user.home");
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        try {

            $validateTask = Validator::make($request->all(), [
                'title' => 'required|max:50',
                'description' => 'required|min:100',
            ]);

            if ($validateTask->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error !',
                    'errors' => $validateTask->errors(),
                ], 401);
            }

            Task::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            return redirect()->route('home')->with('success', 'Create Task Successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}

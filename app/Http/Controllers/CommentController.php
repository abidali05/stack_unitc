<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = Comment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'comment' => $validated['comment'],
        ]);

        return response()->json([
            'status' => 'success',
            'comment' => [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'user' => Auth::user()->name,
                'created_at' => $comment->created_at->timezone('Asia/Karachi')->format('Y-m-d H:i:s'), // PKT timezone
            ],
        ]);
    }
}

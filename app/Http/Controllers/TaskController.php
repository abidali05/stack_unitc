<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function fetchTasks(Request $request)
    {
        $query = Task::with(['project', 'assignee', 'project.creator']);

        if ($request->has('project_id') && $request->project_id !== 'all') {
            $query->where('project_id', $request->project_id);
        }

        if ($request->has('min_date')) {
            $query->whereHas('project', function ($q) use ($request) {
                $q->where('start_date', '>=', $request->min_date);
            })->orWhere('due_date', '>=', $request->min_date);
        }

        if ($request->has('max_date')) {
            $query->where('due_date', '<=', $request->max_date);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $tasks = $query->get()->map(function ($task) {
            $startDate = $task->project ? $task->project->start_date : null;
            $expectedDays = $startDate && $task->due_date
                ? Carbon::parse($startDate)->diffInDays($task->due_date)
                : null;
            $daysUsed = $startDate
                ? Carbon::parse($startDate)->diffInDays($task->completed_at ?? now())
                : null;

            return [
                'id' => $task->id,
                'project_id' => $task->project_id,
                'project_name' => $task->project ? $task->project->name : 'Unknown',
                'project' => $task->project ? [
                    'name' => $task->project->name,
                    'start_date' => $task->project->start_date,
                    'creator' => $task->project->creator ? ['name' => $task->project->creator->name] : null,
                ] : null,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'priority' => $task->priority,
                'due_date' => $task->due_date,
                'completed_at' => $task->completed_at,
                'assignee' => $task->assignee ? ['id' => $task->assignee->id, 'name' => $task->assignee->name] : null,
                'expected_days' => $expectedDays,
                'days_used' => $daysUsed,
            ];
        });

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task = Task::create([
            'project_id' => $validated['project_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'assigned_to' => $validated['assigned_to'],
            'status' => $validated['status'],
            'priority' => $validated['priority'],
            'due_date' => $validated['due_date'],
            'completed_at' => $validated['status'] === 'done' ? now() : null,
        ]);

        TaskStatus::create([
            'task_id' => $task->id,
            'status' => $task->status,
            'priority' => $task->priority,
            'updated_by' => Auth::id(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Task created successfully']);
    }

    public function show(Task $task)
{
    $task->load(['project.creator', 'assignee', 'statusHistory.user', 'comments.user']);
    return response()->json([
        'id' => $task->id,
        'title' => $task->title,
        'description' => $task->description,
        'status' => $task->status,
        'priority' => $task->priority,
        'due_date' => $task->due_date ? Carbon::parse($task->due_date)->format('Y-m-d') : null,
        'completed_at' => $task->completed_at ? Carbon::parse($task->completed_at)->format('Y-m-d') : null,
        'created_at' => $task->created_at ? Carbon::parse($task->created_at)->format('Y-m-d') : null,
        'project' => [
            'id' => $task->project->id,
            'name' => $task->project->name,
            'start_date' => $task->project->start_date ? Carbon::parse($task->project->start_date)->format('Y-m-d') : null,
            'creator' => $task->project->creator ? ['name' => $task->project->creator->name] : null,
        ],
        'assignee' => $task->assignee ? ['name' => $task->assignee->name] : null,
        'expected_days' => $task->due_date && $task->project->start_date
            ? Carbon::parse($task->project->start_date)->diffInDays($task->due_date)
            : null,
        'days_used' => $task->project->start_date
            ? Carbon::parse($task->project->start_date)->diffInDays($task->completed_at ?? now())
            : null,
        'status_history' => $task->statusHistory->map(function ($status) {
            return [
                'status' => ucfirst(str_replace('_', ' ', $status->status)),
                'priority' => ucfirst($status->priority),
                'date' => $status->created_at->format('Y-m-d H:i:s'),
                'updated_by' => $status->user->name ?? 'Unknown',
            ];
        }),
        'comments' => $task->comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'user' => $comment->user->name ?? 'Unknown',
                'created_at' => $comment->created_at->format('Y-m-d H:i:s'), // Changed toLocaleString to format
            ];
        }),
    ]);
}

    public function edit(Task $task)
    {
        return response()->json([
            'id' => $task->id,
            'project_id' => $task->project_id,
            'title' => $task->title,
            'description' => $task->description,
            'assigned_to' => $task->assigned_to,
            'due_date' => $task->due_date ? Carbon::parse($task->due_date)->format('Y-m-d') : null,
            'status' => $task->status,
            'priority' => $task->priority,
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $statusChanged = $task->status !== $validated['status'] || $task->priority !== $validated['priority'];

        $task->update([
            'project_id' => $validated['project_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'assigned_to' => $validated['assigned_to'],
            'status' => $validated['status'],
            'priority' => $validated['priority'],
            'due_date' => $validated['due_date'],
            'completed_at' => $validated['status'] === 'done' ? now() : null,
        ]);

        if ($statusChanged) {
            TaskStatus::create([
                'task_id' => $task->id,
                'status' => $task->status,
                'priority' => $task->priority,
                'updated_by' => Auth::id(),
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Task updated successfully']);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update([
            'status' => $validated['status'],
            'completed_at' => $validated['status'] === 'done' ? now() : null,
        ]);

        TaskStatus::create([
            'task_id' => $task->id,
            'status' => $task->status,
            'priority' => $task->priority,
            'updated_by' => Auth::id(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Task status updated successfully']);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['status' => 'success', 'message' => 'Task deleted successfully']);
    }
}

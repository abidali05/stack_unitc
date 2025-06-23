<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Email;
use App\Models\Media;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ProjectStatus;
use Illuminate\Support\Facades\DB;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        $projects = Project::with('user')->get();
        $projects->each(function ($project) {
            $expectedDays = $project->expected_days;
            $daysUsed = $project->days_used;

            $project->expected_days = $expectedDays;
            $project->days_used = $daysUsed;
        });
        // dd($projects);
        $completedProjects = Project::where('status', 'completed')->count();
        $inProgressProjects = Project::where('status', 'inprogress')->count();
        $holdProjects = Project::where('status', 'hold')->count();
        $overdueProjects = Project::where('deadline', '<', DB::raw('DATE(NOW())'))
            ->whereIn('status', ['todo', 'inprogress', 'hold'])
            ->count();
        //
        $emails = Email::with('receiver')->where('receiver_id', auth()->id())->get();

        $media = Media::where('user_id', auth()->id())->get();

        return view('pages.project', compact('users', 'projects', 'completedProjects', 'inProgressProjects', 'overdueProjects', 'holdProjects', 'emails', 'media'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'project_name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'task' => 'required|string',
            'category' => 'required|in:task,tweak,bug,custom',
            'status' => 'required|in:todo,inprogress,hold,completed',
            'start_date' => 'nullable|date',
            'deadline' => 'required|date|after_or_equal:start_date',
            // 'document' => 'required',
        ]);

        //dd('1');
        $data = [
            'project_name' => $request->input('project_name'),
            'user_id' => $request->input('user_id'),
            'task' => $request->input('task'),
            'category' => $request->input('category'),
            'status' => $request->input('status'),
            'start_date' => $request->input('start_date'),
            'deadline' => $request->input('deadline'),
            'assigned_by' => auth()->id(),
        ];

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileName = time() . '_' . uniqId() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('documents'), $fileName);
            $data['document'] = 'documents/' . $fileName;
        }

        //dd($data);
        Project::create($data);

        return response()->json(['status' => 'success', 'message' => 'Project created successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->increment('view_count');
        $project = Project::with('user')->findOrFail($project->id);
        //dd($project->toArray());
        return response()->json([
            'project_name'    => $project->project_name,
            'user_name'       => $project->user->name,
            'task'            => $project->task,
            'category'        => ucfirst($project->category), // Adding category data
            'status'          => ucfirst($project->status),
            'view_count'      => $project->view_count,
            'deadline' => $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d-m-Y') : '',
            'start_date' => $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d-m-Y') : '',
            'end_date' => $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d-m-Y') : '',
            'document'    => $project->document ? asset($project->document) : null, // Adjust document url path
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Project $project)
    // {
    //     $request->validate([
    //         'project_name' => 'string',
    //         'user_id' => 'nullable|exists:users,id',
    //         'task' => 'string',
    //         'deadline' => 'date',
    //         'status' => 'string',
    //     ]);

    //     $project->update($request->except(['_token', '_method']));

    //     return response()->json([
    //         'message' => 'Project updated successfully.',
    //         'project' => $project
    //     ]);
    // }
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'task' => 'required|string',
            'category' => 'required|in:task,tweak,bug,custom',
            'status' => 'required|in:todo,inprogress,hold,completed,reopen',
            'start_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:start_date',
            //'document' => 'required',
        ]);

        $statusChanged = $request->has('status') && $project->status !== $request->status;

        $data = [
            'project_name' => $request->input('project_name', $project->project_name),
            'user_id' => $request->input('user_id', $project->user_id),
            'task' => $request->input('task', $project->task),
            'category' => $request->input('category', $project->category),
            'status' => $request->input('status', $project->status),
            'start_date' => $request->input('start_date', $project->start_date),
            'deadline' => $request->input('deadline', $project->deadline),
        ];
        // dd($data);
        if ($request->status === 'reopen') {
            $data['end_date'] = null;
        }

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileName = time() . '_' . uniqId() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('documents'), $fileName);
            $data['document'] = 'documents/' . $fileName;
        }
        //dd($request->all());
        $project->update($data);

        if ($statusChanged) {
            ProjectStatus::create([
                'project_id' => $project->id,
                'status' => $request->status,
                'updated_by' => auth()->id(),
                'category' => $request->category
            ]);
        }
        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Project updated successfully.',
            'project' => [
                'id' => $project->id,
                'project_name' => $project->project_name,
                'user_name' => $project->user->name,
                'task' => $project->task,
                'category' => $project->category,
                'status' => $project->status,
                'start_date_formatted' => $project->start_date,
                'end_date_formatted' => $project->end_date ? $project->end_date : null,
                'expected_days' => $project->expected_days,
                'deadline' => $project->deadline,
                'days_used' => $project->days_used,
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project = Project::findOrFail($project->id);
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully']);
    }

    public function getProjectGraph()
    {
        $projectsGraph = Project::select('project_name')
            ->selectRaw(
                '
                sum(status = "inprogress") as inprogress,
                sum(status = "hold") as hold,
                sum(deadline < ? and status != "completed") as overdue',
                [Carbon::now()]
            )
            ->groupBy('project_name')
            ->get()
            ->map(function ($project) {
                $project->inprogress = (int) $project->inprogress;
                $project->hold = (int) $project->hold;
                $project->overdue = (int) $project->overdue;
                return $project;
            });

        return response()->json($projectsGraph);
    }

    public function getProjectDetails($id)
    {
        //dd($id);
        $project = Project::with(['user', 'statuses', 'assignedBy'])->findOrFail($id);
        return response()->json([
            'id' => $project->id,
            'title' => $project->project_name,
            'posted_date' => $project->created_at->format('Y-m-d'),
            'assigned_to' => $project->user->name ?? 'N/A',
            'assigned_by' => $project->assignedBy->name ?? 'N/A',
            'task' => $project->task,
            'deadline' => $project->deadline,
            'category' => $project->category,
            'start_date' => $project->start_date ?? 'N/A',
            'end_date' => $project->end_date ?? 'N/A',
            'expected_days' => $project->expected_days ?? 'N/A',
            'days_used' => $project->days_used ?? 'N/A',
            'status' => $project->status,
            'status_color' => $this->getStatusColor($project->status),
            'document' => $project->document ?? 'N/A',
            'view_count' => $project->view_count,

            'status_history' => $project->statuses->map(function ($status) {
                return [
                    'id' => $status->id,
                    'category' => $status->category,
                    'status' => $status->status,
                    'date' => $status->created_at->format('Y-m-d H:i:s'),
                    'updated_by' => $status->user->name,
                    'color' => $this->getStatusColor($status->status),
                ];
            }),
        ]);
    }

    private function getStatusColor($status)
    {
        return match ($status) {
            'completed' => 'success',
            'inprogress' => 'danger',
            'reopen' => 'warning',
            'hold' => 'dark',
            'todo' => 'primary',
        };
    }

    public function updateStatus(Request $request)
    {
        $task = Project::find($request->task_id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->status = $request->status;

        if ($request->status === 'completed' && !$task->end_date) {
            $task->end_date = Carbon::now();
        }

        $task->save();

        $completedProjects = Project::where('status', 'completed')->count();
        $inProgressProjects = Project::where('status', 'inprogress')->count();
        $holdProjects = Project::where('status', 'hold')->count();
        $overdueProjects = Project::where('deadline', '<', Carbon::now())->where('status', '!=', 'completed')->count();

        return response()->json([
            'success' => 'Task updated successfully',
            'completedProjects' => $completedProjects,
            'inProgressProjects' => $inProgressProjects,
            'holdProjects' => $holdProjects,
            'overdueProjects' => $overdueProjects
        ]);
    }

    public function fetchProjects()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        $projects = Project::with('user')->get();

        $projects->each(function ($project) {
            $project->expected_days = $project->expected_days;
            $project->days_used = $project->days_used;
        });

        $completedProjects = Project::where('status', 'completed')->count();
        $inProgressProjects = Project::where('status', 'inprogress')->count();
        $holdProjects = Project::where('status', 'hold')->count();
        $overdueProjects = Project::where('deadline', '<', DB::raw('DATE(NOW())'))
            ->whereIn('status', ['todo', 'inprogress', 'hold'])
            ->count();

        return response()->json([
            'projects' => $projects,
            'completedProjects' => $completedProjects,
            'inProgressProjects' => $inProgressProjects,
            'holdProjects' => $holdProjects,
            'overdueProjects' => $overdueProjects
        ]);
    }
}

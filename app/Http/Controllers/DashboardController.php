<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Email;
use App\Models\Media;
use App\Models\Calendar;
use App\Models\FileSync;
use Illuminate\Http\Request;
use App\Models\FileSyncShare;
use App\Traits\NewsFeedTrait;
use App\Services\CalendarService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CalendarRequest;
use App\Models\Team;
use App\Notifications\EventNotification;
use Illuminate\Support\Facades\Notification;

class DashboardController extends Controller
{
    use NewsFeedTrait;

    protected CalendarService $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // this is for showing modal after login
        $showModal = !session()->has('first_dashboard_visit');
        session(['first_dashboard_visit' => false]);

        $emails = Email::with('receiver')->where('receiver_id', auth()->id())->where('is_draft', false)->whereNull('folder_id')->get();

        $files = FileSync::where('user_id', auth()->id())->orWhereHas('shares', function ($query) {
            $query->where('share_with_user_id', auth()->id());
        })->get();

        $media = Media::where('user_id', auth()->id())->get();

        $events = Calendar::all();

        // this is service
        $allArticles = $this->getAllNews();

        return view('pages.dashboard', compact('emails', 'files', 'allArticles', 'showModal', 'media', 'events'));
    }

    public function getUsers()
    {
        //exclude login user
        $users = User::where('id', '!=', auth()->id())->get(['id', 'name', 'email']);
        return response()->json($users);
    }

    public function getTeams()
    {
        return response()->json(Team::select('id', 'team_name')->get());
    }

    public function shareFile(Request $request)
    {

        $request->validate([
            'file_id' => 'required|exists:file_syncs,id',
            'user_ids' => 'array',
            'team_ids' => 'array',
        ]);
        $fileId = $request->file_id;
       // $userIds = $request->user_ids;

        if (!empty($request->user_ids)) {
            foreach ($request->user_ids as $key => $userId) {
                FileSyncShare::create([
                    'file_id' => $fileId,
                    'share_with_user_id' => $userId,
                    'share_by_user_id' => auth()->id(),
                ]);
            }
        }

        if (!empty($request->team_ids)) {

            $teamUsers = User::whereIn('id', function ($query) use ($request) {
                $query->select('user_id')->from('team_user')->whereIn('team_id', $request->team_ids);
            })->get();

            // dd($teamUsers);

            foreach ($teamUsers as $user) {
                FileSyncShare::create([
                    'file_id' => $fileId,
                    'share_with_user_id' => $user->id,
                    'share_by_user_id' =>  auth()->id(),
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'File shared successfully!']);
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
        // dd($request->all());
        // try {
        $validated = $request->validate([
            'media' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,avi,mkv,mp3,wav,ogg', // Accept all media types
        ]);

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $filename = time() . '_' . $file->getClientOriginalName();

            $mimeType = $file->getClientMimeType();
            $path = '';

            if (strpos($mimeType, 'image') !== false) {
                $file->move(public_path('media/images'), $filename);
                $path = '/media/images/' . $filename;
                $type = 'image';
            } elseif (strpos($mimeType, 'video') !== false) {
                $file->move(public_path('media/videos'), $filename);
                $path = '/media/videos/' . $filename;
                $type = 'video';
            } elseif (strpos($mimeType, 'audio') !== false) {
                $file->move(public_path('media/audios'), $filename);
                $path = '/media/audios/' . $filename;
                $type = 'audio';
            }
        }

        $media = Media::create([
            'user_id' => auth()->id(),
            'type' => $type,
            'filename' => $filename,
            'path' => $path,
        ]);

        $media->load('user');
        //$media = Media::with('user')->where('user_id', auth()->id())->get();

        return response()->json(['success' => 'Media uploaded successfully.', 'media' => [$media]]);
        // } catch (\Throwable $th) {
        //     dd($th->getMessage());
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $media = Media::findOrFail($id);

        // Delete the file from storage
        if (file_exists(public_path($media->path))) {
            unlink(public_path($media->path));
        }

        // Delete the database record
        $media->delete();

        return response()->json(['success' => 'Media deleted successfully.']);
    }

    public function event_store(CalendarRequest $request, $id = null): JsonResponse
    {
        $data = $request->except('users');
        //dd($request->all());

        if (!empty($data['notification_type']) && is_array($data['notification_type'])) {
            $data['notification_type'] = json_encode($data['notification_type']);
        }

        // if(!$id){
        //     $data['created_by'] = auth()->id();
        // }

        $event = Calendar::updateOrCreate(
            ['id' => $id],
            $data
        );

        if ($request->has('users')) {
            $event->users()->sync($request->users);
        }

        if ($request->recurrence_mode !== 'never') {
            $this->calendarService->generateRecurringEvents($event, $request);
        }

        if ($event->send_notification) {
            $this->calendarService->sendNotification($event);
        }

        return response()->json([
            'message' => 'Event saved successfully',
            'event' => $event
        ], 201);
    }

    public function fullCalendar()
    {
        $allArticles = $this->getAllNews();
        $emails = Email::with('receiver')->where('receiver_id', auth()->id())->get();
        $media = Media::where('user_id', auth()->id())->get();
        return view('pages.full-calendar', compact('allArticles', 'emails', 'media'));
    }

    public function getEvents()
    {
        $events = Calendar::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->event_title,
                'start' => $event->all_day
                    ? $event->event_date
                    : $event->event_date . 'T' . $event->event_start_time,
                'end' => $event->event_end_time
                    ? $event->event_date . 'T' . $event->event_end_time
                    : null,
                'allDay' => (bool) $event->all_day,
                'description' => $event->event_description,
                'location' => $event->event_location,
                //'created_by' => $event->creator ? $event->creator->name : 'Unknown'
            ];
        });

        return response()->json($events);
    }

    public function deleteEvent($id)
    {
        $item = Calendar::findOrFail($id);
        $item->delete();
        return redirect()->route('dashboard')->with('success', 'Event deleted successfully!');
    }

    public function sendTestMail()
    {
        $event = Calendar::first();
        //dd($event);
        try {
            Notification::route('mail', 'azharmehmood74600@gmail.com')->notify(new EventNotification($event));
            return response()->json(['message' => 'Test email sent!']);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function emailFilter(Request $request)
    {
        $type = $request->get('type', 'inbox');

        switch ($type) {
            case 'inbox':
                $emails = Email::where('receiver_id', auth()->id())->where('is_draft', false)->whereNull('folder_id')->orderBy('created_at', 'desc')->get();
                break;
            case 'unread':
                $emails = Email::where('receiver_id', auth()->id())->where('is_read', false)->where('is_draft', false)->get();
                break;
            case 'starred':
                $emails = Email::where(function ($q) {
                    $q->where('receiver_id', auth()->id())->orWhere('sender_id', auth()->id());
                })->where('is_starred', true)->get();
                break;
            case 'sent':
                $emails = Email::where('sender_id', auth()->id())->where('is_draft', false)->get();
                break;
            case 'draft':
                $emails = Email::where('sender_id', auth()->id())->where('is_draft', true)->get();
                break;
            case 'trash':
                $emails = Email::onlyTrashed()
                ->where(function ($query) {
                    $query->where('receiver_id', auth()->id())
                        ->orWhere('sender_id', auth()->id());
                })->get();                break;
            default:
                $emails = Email::where('receiver_id', auth()->id())->get();
                break;
        }

        return view('partials.email_rows', compact('emails'));
    }

    public function toggleStar($id)
    {
        $email = Email::where(function ($query) {
            $query->where('receiver_id', auth()->id())
                ->orWhere('sender_id', auth()->id());
        })->findOrFail($id);

        $email->is_starred = !$email->is_starred;
        $email->save();

        return response()->json(['is_starred' => $email->is_starred]);
    }
}

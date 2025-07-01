<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Email;
use App\Models\Media;
use App\Models\Folder;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($type = 'inbox')
    {
        $emails = [];
        $media = Media::where('user_id', auth()->id())->get();
        $folders = Folder::get();
        switch ($type) {
            case 'inbox':
                $emails = Email::where('receiver_id', auth()->id())->where('is_draft', false)->whereNull('folder_id')
                    ->orderBy('created_at', 'desc')
                    ->take(4)->get();
                break;
            case 'unread':
                $emails = Email::where('receiver_id', auth()->id())->where('is_read', false)->where('is_draft', false)->get();
                break;
            case 'starred':
                $emails = Email::where(function ($query) {
                    $query->where('receiver_id', auth()->id())
                          ->orWhere('sender_id', auth()->id());
                })
                ->where('is_starred', true)
                ->get();
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
                    })->get();
                break;
            default:
                $emails = Email::where('receiver_id', auth()->id())->get();
                break;
        }

        return view('pages.email', compact('emails', 'type', 'folders', 'media'));
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
        // Validate input data
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Find the receiver
        $receiver = User::where('email', $validatedData['email'])->first();

        if (!$receiver) {
            return back()->with('error', 'The provided email does not belong to any user.');
        }

        if ($request->draft_id) {
            // Update the existing draft record
            $email = Email::find($request->draft_id);

            if ($email) {
                $email->update([
                    'sender_id' => auth()->id(),
                    'receiver_id' => $receiver->id,
                    'email' => $validatedData['email'],
                    'subject' => $validatedData['subject'],
                    'description' => $validatedData['body'],
                    'is_draft' => false,
                ]);

                return back()->with('success', 'Email sent successfully!');
            }

            return back()->with('error', 'Draft email not found.');
        }

        // Create a new email record
        Email::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiver->id,
            'email' => $validatedData['email'],
            'subject' => $validatedData['subject'],
            'description' => $validatedData['body'],
            'is_draft' => false,
        ]);

        return back()->with('success', 'Email sent successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Email $email)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Email $email)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Email $email)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $folder = Folder::find($id);

        if ($folder) {
            $folder->delete();
            return response()->json(['success' => true, 'message' => 'Folder deleted successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Folder not found.']);
    }


    public function toggleStar(Request $request, $id)
    {
        $email = Email::where('id', $id)
            ->first();
        if ($email) {
            $email->is_starred = $request->input('is_starred', !$email->is_starred);
            $email->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Email not found']);
    }

    public function markAsRead($id)
    {
        $email = Email::find($id);
        if ($email) {
            $email->is_read = 1;
            $email->save();

            return response()->json([
                'success' => true,
                'email' => [
                    'subject' => $email->subject,
                    'sender' => $email->sender,
                    'date' => $email->created_at->format('d M, Y H:i A'),
                    'content' => $email->description
                ]
            ]);
        }
        return response()->json(['success' => false, 'error' => 'Email not found']);
    }

    public function toggleDraft(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'nullable|email',
            'subject' => 'nullable|string',
            'body' => 'nullable|string',
        ]);

        $receiver = User::where('email', $validatedData['email'])->first();

        $email = Email::updateOrCreate(
            ['id' => $request->input('draft_id')],
            [
                'sender_id' => auth()->id(),
                'receiver_id' => $receiver->id ?? null,
                'email' => $validatedData['email'] ?? null,
                'subject' => $validatedData['subject'] ?? null,
                'description' => $validatedData['body'] ?? null,
                'is_draft' => true,
            ]
        );

        return response()->json([
            'success' => true,
            'draft_id' => $email->id,
        ]);
    }

    public function deleteEmail($id)
    {
        $email = Email::withTrashed()->find($id);

        if ($email->trashed()) {
            $email->forceDelete();
        } else {
            $email->delete();
        }

        return response()->json(['success' => true]);
    }

    public function moveEmail(Request $request, $emailId)
    {
        $email = Email::findOrFail($emailId);

        $email->folder_id = $request->input('folder_id');
        $email->save();

        return response()->json(['success' => true]);
    }

    public function getFolderEmails($folderId)
    {
        $emails = Email::where('receiver_id', auth()->id())
            ->where('folder_id', $folderId)
            ->get();

        return response()->json(['emails' => $emails]);
    }

    public function getEmailDetails($emailId)
    {
        $email = Email::with('sender')->findOrFail($emailId);
        return response()->json($email);
    }
}

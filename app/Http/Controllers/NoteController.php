<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Note;
use App\Models\Email;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::with('user')->where('user_id', auth()->id())->latest()->get();
        $emails = Email::with('receiver')->where('receiver_id', auth()->id())->get();
        $media = Media::where('user_id', auth()->id())->get();
        return view('pages.note', compact('notes','emails', 'media'));
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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id()
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . uniqId() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('notes'), $fileName);
            $data['image'] = 'notes/' . $fileName;
        } else {
            $data['image'] = 'images/default-notes.png';
        }

        $note = Note::create($data);
        return redirect()->back()->with('success', 'Notes have been saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        $note->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Note updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully.'
        ]);
    }

    public function filterNotes(Request $request)
    {
        $date = $request->get('date');
        $notes = Note::query();
        if ($date) {
            $notes = $notes->whereDate('created_at', Carbon::parse($date));
        }
        $notes = $notes->with('user')->where('user_id', auth()->id())->get();
        return response()->json(['notes' => $notes]);
    }
}

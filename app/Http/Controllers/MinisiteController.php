<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Email;
use App\Models\Media;
use App\Models\Minisite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MinisiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emails = Email::with('receiver')->where('receiver_id', auth()->id())->get();
        $media = Media::where('user_id', auth()->id())->get();
        $teams =  Team::all();
        return view('pages.minisite', compact('emails', 'media', 'teams'));
    }

    public function storePage(Request $request)
    {
        try {
            $request->validate([
                'page_logo' => 'nullable|image',
                'page_title' => 'required|string|max:255',
                'page_description' => 'nullable|string',
                'team_id' => 'required|exists:teams,id',
            ]);

            if ($request->hasFile('page_logo')) {
                $file = $request->file('page_logo');
                $destinationPath = public_path('minisite');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $fileName);
                $pageLogo = 'minisite/' . $fileName;
            } else {
                $pageLogo = null;
            }

            Minisite::create([
                'page_logo' => $pageLogo,
                'page_title' => $request->page_title,
                'page_description' => $request->page_description,
                'page_added_by' => Auth::id(),
                'team_id' => $request->team_id,
            ]);

            return redirect()->back()->with('success', 'Page added successfully!');
        } catch (\Throwable $e) {
            return back()->with('error', 'Error creating Minisite: ' . $e->getMessage());
        }
    }

    public function storeDocument(Request $request)
    {
        $request->validate([
            'document' => 'required',
            'document_title' => 'required|string|max:255',
            'team_id' => 'required|exists:teams,id',
        ]);

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('minisite'), $fileName);
            $documentPath = 'minisite/' . $fileName;
        } else {
            $documentPath = null;
        }

        Minisite::create([
            'document' => $documentPath,
            'document_title' => $request->document_title,
            'document_added_by' => Auth::id(),
            'team_id' => $request->team_id,
        ]);

        return redirect()->back()->with('success', 'Document added successfully!');
    }

    public function getMinisiteRecords($teamId)
    {
        $records = Minisite::where('team_id', $teamId)->get(['id', 'page_title']);
        return response()->json($records);
    }

    public function getPageRecords($id)
    {
        // Fetch records associated with the selected page
        $records = Minisite::where('id', $id)->get(['id', 'page_title', 'page_description', 'page_logo as image']);
        return response()->json($records);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Minisite $minisite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $page = Minisite::find($id);
        return response()->json($page);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //dd($request->all(), $request->file('page_logo'));
        $page = Minisite::find($id);
        if (!$page) {
            return response()->json(['success' => false, 'message' => 'Page not found.']);
        }

        $page->page_title = $request->page_title;
        $page->page_description = $request->page_description;

        if ($request->hasFile('page_logo')) {

            if ($page->page_logo && file_exists(public_path($page->page_logo))) {
                unlink(public_path($page->page_logo));
            }

            $file = $request->file('page_logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('minisite');
            $file->move($destinationPath, $fileName);

            $page->page_logo = 'minisite/' . $fileName;
        }
        //dd($page, $request->all());
        $page->save();

        return response()->json(['success' => true, 'message' => 'Page updated successfully.']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $page = Minisite::find($id);
        if (!$page) {
            return response()->json(['success' => false, 'message' => 'Page not found.']);
        }

        if ($page->image && file_exists(public_path($page->image))) {
            unlink(public_path($page->image));
        }

        $page->delete();

        return response()->json(['success' => true, 'message' => 'Page deleted successfully.']);
    }
}

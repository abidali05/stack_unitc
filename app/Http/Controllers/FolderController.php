<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $folder = Folder::create([
            'name' => $request->input('name'),
            'user_id' => auth()->id()
        ]);

        // Respond with JSON
        return response()->json([
            'success' => true,
            'folder' => $folder,
            'message' => 'Folder created successfully!',
        ]);
    }
}

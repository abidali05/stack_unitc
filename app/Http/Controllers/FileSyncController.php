<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Email;
use App\Models\Media;
use App\Models\FileSync;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class FileSyncController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $media = Media::where('user_id', auth()->id())->get();
        $emails = Email::with('receiver')->where('receiver_id', auth()->id())->get();
        return view('pages.file_sync', compact('emails', 'media'));
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
        $uploadType = $request->input('upload_type');

        try {
            switch ($uploadType) {
                case 'file':
                    $request->validate(['file' => 'required|file']);

                    $file = $request->file('file');
                    $fileName = $file->getClientOriginalName();
                    $fileMimeType = $file->getMimeType();
                    $fileSize = $file->getSize();
                    $destinationPath = public_path('uploads');
                    $file->move($destinationPath, $fileName);
                    $newFilePath = "uploads/$fileName";

                    $fileRecord = FileSync::create([
                        'name' => $fileName,
                        'path' => $newFilePath,
                        'type' => 'file',
                        'mime_type' => $fileMimeType,
                        'size' => $fileSize,
                        'user_id' => auth()->id(),
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'File uploaded successfully!',
                        'file' => [
                            'id' => $fileRecord->id,
                            'name' => $fileName,
                            'path' => asset($newFilePath), // Full URL to the file
                            'type' => $this->getFileType($fileName),
                            'image_path' => $this->getFileIcon($fileName),
                        ]
                    ]);

                case 'folder':
                    $request->validate(['folder_name' => 'required|string', 'files.*' => 'required|file']);

                    $folderName = $request->input('folder_name');
                    $folderPath = public_path("uploads/$folderName");

                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0777, true);
                    }

                    $folder = FileSync::firstOrCreate([
                        'path' => "uploads/$folderName",
                        'user_id' => auth()->id(),
                    ], [
                        'name' => $folderName,
                        'type' => 'folder',
                        'size' => null,
                        'mime_type' => null,
                    ]);

                    $uploadedFiles = [];
                    foreach ($request->file('files') as $file) {
                        $fileName = $file->getClientOriginalName();
                        $fileMimeType = $file->getMimeType();
                        $fileSize = $file->getSize();
                        $filePath = "uploads/$folderName/$fileName";
                        $file->move($folderPath, $fileName);

                        $fileRecord = FileSync::create([
                            'name' => $fileName,
                            'path' => $filePath,
                            'type' => 'file',
                            'mime_type' => $fileMimeType,
                            'size' => $fileSize,
                            'user_id' => auth()->id(),
                            'parent_id' => $folder->id,
                        ]);

                        $uploadedFiles[] = [
                            'id' => $fileRecord->id,
                            'name' => $fileName,
                            'path' => asset($filePath),
                            'type' => $this->getFileType($fileName),
                            'image_path' => $this->getFileIcon($fileName),
                        ];
                    }

                    return response()->json([
                        'success' => true,
                        'message' => 'Folder uploaded successfully!',
                        'folder' => [
                            'id' => $folder->id,
                            'name' => $folderName,
                            'path' => asset("uploads/$folderName"),
                            'type' => 'folder',
                            'image_path' => asset('images/folder-icon.png'), // Adjust path as needed
                        ],
                        'files' => $uploadedFiles
                    ]);

                default:
                    return response()->json(['success' => false, 'message' => 'Upload Failed!']);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Upload Failed: ' . $e->getMessage()]);
        }
    }

    // Helper method to determine file type
    private function getFileType($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        return match ($extension) {
            'pdf' => 'pdf',
            'doc', 'docx' => 'word',
            'xls', 'xlsx' => 'xlsx',
            'ppt', 'pptx' => 'ppt',
            'zip', 'rar' => 'zip',
            'jpg', 'jpeg', 'png', 'gif' => 'image',
            default => 'file',
        };
    }

    // Helper method to get appropriate icon
    private function getFileIcon($filename)
    {
        $type = $this->getFileType($filename);
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $imagePaths = [
            'pdf' => asset('files/pdf.jpg'),
            'word' => asset('files/word.jpg'),
            'xlsx' => asset('files/xlsx.jpg'),
            'ppt' => asset('files/ppt.jpg'),
            'zip' => asset('files/zip.jpg'),
            'folder' => asset('files/folder.png'),
            'file' => asset('files/file.png'),
        ];

        // If it's an image file, return the actual image path
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            return asset("uploads/$filename");
        }

        return $imagePaths[$type] ?? $imagePaths['file'];
    }
    /**
     * Display the specified resource.
     */
    public function show(FileSync $fileSync)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileSync $fileSync)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FileSync $fileSync)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FileSync $fileSync)
    {
        $filePath = public_path($fileSync->path);
        if (file_exists($filePath)) {
            if (is_file($filePath)) {
                unlink($filePath);
            } elseif (is_dir($filePath)) {
                File::deleteDirectory($filePath);
            }
        }

        FileSync::where('parent_id', $fileSync->id)->delete();

        $fileSync->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.'
        ]);
    }

    public function rename(Request $request, $id)
    {
        $request->validate([
            'new_name' => 'required|string|max:255',
        ]);

        $file = FileSync::findOrFail($id);

        $oldName = $file->name; //get name
        $oldPath = public_path($file->path); //get path
        $extension = pathinfo($oldName, PATHINFO_EXTENSION); // get extension

        $newName = $request->new_name . '.' . $extension;
        $newPath = 'uploads/' . $newName;

        if (file_exists($oldPath)) {
            rename($oldPath, public_path($newPath));
        }

        $file->name = $newName;
        $file->path = $newPath;
        $file->save();

        return response()->json(['success' => true, 'message' => 'File renamed successfully.']);
    }

    public function downloadFolder($folderPath)
    {
        $folderPath = urldecode($folderPath);
        $fullPath = public_path($folderPath);

        if (!File::exists($fullPath) || !File::isDirectory($fullPath)) {
            return response()->json(['error' => 'Folder does not exist'], 404);
        }

        $files = File::allFiles($fullPath);
        $fileUrls = [];

        foreach ($files as $file) {
            $fileUrls[] = asset("$folderPath/" . $file->getFilename());
        }

        return response()->json(['files' => $fileUrls]);
    }

    public function filter(Request $request)
    {
        $type = $request->input('type');
        $files = FileSync::where('user_id', auth()->id())->orWhereHas('shares', function ($query) {
            $query->where('share_with_user_id', auth()->id());
        })->get();

        if ($type === 'shared') {
            $sharedFiles = FileSync::whereHas('shares', function ($query) {
                $query->where('share_with_user_id', auth()->id());
            })->get();

            return response()->json($sharedFiles->map(function ($file) {
                $extension = strtolower(pathinfo($file->path, PATHINFO_EXTENSION));
                $type = match ($extension) {
                    'pdf' => 'pdf',
                    'xlsx' => 'xlsx',
                    'zip' => 'zip',
                    'doc', 'docx' => 'word',
                    'ppt', 'pptx' => 'ppt',
                    'jpeg', 'jpg', 'png', 'gif', 'bmp', 'svg' => 'image',
                    default => 'file',
                };

                $imagePaths = [
                    'pdf' => asset('files/pdf.jpg'),
                    'xlsx' => asset('files/xlsx.jpg'),
                    'zip' => asset('files/exe.jpg'),
                    'word' => asset('files/word.jpg'),
                    'ppt' => asset('files/ppt.jpg'),
                    'folder' => asset('files/folder.png'),
                    'file' => asset('files/file.png'),
                ];

                $imagePath = in_array($extension, ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'svg'])
                    ? asset($file->path)
                    : $imagePaths[$type] ?? $imagePaths['file'];

                return [
                    'id' => $file->id,
                    'name' => $file->name,
                    'type' => $type,
                    'image_path' => $imagePath,
                    'path' => $file->path,
                ];
            })->toArray());
        }

        if ($type === 'all') {
            return response()->json($files->filter(function ($file) {
                return $file->type !== 'folder'; // Exclude folders
            })->map(function ($file) {
                $extension = strtolower(pathinfo($file->path, PATHINFO_EXTENSION));
                $type = match ($extension) {
                    'pdf' => 'pdf',
                    'xlsx' => 'xlsx',
                    'zip' => 'zip',
                    'doc', 'docx' => 'word',
                    'ppt', 'pptx' => 'ppt',
                    'jpeg', 'jpg', 'png', 'gif', 'bmp', 'svg' => 'image',
                    default => 'file',
                };

                $imagePaths = [
                    'pdf' => asset('files/pdf.jpg'),
                    'xlsx' => asset('files/xlsx.jpg'),
                    'zip' => asset('files/exe.jpg'),
                    'word' => asset('files/word.jpg'),
                    'ppt' => asset('files/ppt.jpg'),
                    'file' => asset('files/file.png'),
                ];

                $imagePath = in_array($extension, ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'svg'])
                    ? asset($file->path)
                    : $imagePaths[$type] ?? $imagePaths['file'];

                return [
                    'id' => $file->id,
                    'name' => $file->name,
                    'type' => $type,
                    'image_path' => $imagePath,
                    'path' => $file->path,
                ];
            })->toArray());
        }

        // Existing filtering logic for specific file types...
        $filteredFiles = $files->filter(function ($file) use ($type) {
            $extension = strtolower(pathinfo($file->path, PATHINFO_EXTENSION));
            return match ($type) {
                'pdf' => $extension === 'pdf',
                'xlsx' => $extension === 'xlsx',
                'zip' => $extension === 'zip',
                'word' => in_array($extension, ['doc', 'docx']),
                'ppt' => in_array($extension, ['ppt', 'pptx']),
                'folder' => $file->type === 'folder',
                'image' => in_array($extension, ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'svg']),
                default => true,
            };
        });

        // Response generation
        return response()->json($filteredFiles->isEmpty()
            ? ['message' => 'No files found for this filter type.']
            : $filteredFiles->map(function ($file) {
                if ($file->type === 'folder') {
                    return [
                        'id' => $file->id,
                        'name' => $file->name,
                        'type' => 'folder',
                        'image_path' => asset('files/folder.png'), // Ensure the correct folder image
                        'path' => $file->path,
                    ];
                }
                $extension = strtolower(pathinfo($file->path, PATHINFO_EXTENSION));
                $type = match ($extension) {
                    'pdf' => 'pdf',
                    'xlsx' => 'xlsx',
                    'zip' => 'zip',
                    'doc', 'docx' => 'word',
                    'ppt', 'pptx' => 'ppt',
                    'jpeg', 'jpg', 'png', 'gif', 'bmp', 'svg' => 'image',
                    default => 'file',
                };

                $imagePaths = [
                    'pdf' => asset('files/pdf.jpg'),
                    'xlsx' => asset('files/xlsx.jpg'),
                    'zip' => asset('files/exe.jpg'),
                    'word' => asset('files/word.jpg'),
                    'ppt' => asset('files/ppt.jpg'),
                    'folder' => asset('files/folder.png'),
                    'file' => asset('files/file.png'),
                ];

                $imagePath = in_array($extension, ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'svg'])
                    ? asset($file->path) // Assuming images are stored in 'storage'
                    : $imagePaths[$type] ?? $imagePaths['file'];

                return [
                    'id' => $file->id,
                    'name' => $file->name,
                    'type' => $type,
                    'image_path' => $imagePath,
                    'path' => $file->path,
                ];
            })->toArray());
    }

    public function getFolderContent($folderPath)
    {
        $folder = FileSync::where('path', $folderPath)->where('type', 'folder')->first();

        if (!$folder) {
            return response()->json([]);
        }

        // Get all files and subfolders inside the folder
        $files = FileSync::where('parent_id', $folder->id)->get();
        $fileList = [];

        foreach ($files as $file) {
            // Get file extension and determine type
            $extension = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
            $type = match ($extension) {
                'pdf' => 'pdf',
                'xlsx' => 'xlsx',
                'zip' => 'zip',
                'doc', 'docx' => 'word',
                'ppt', 'pptx' => 'ppt',
                'jpeg', 'jpg', 'png', 'gif', 'bmp', 'svg' => 'image',
                default => 'file',
            };

            // Assign appropriate image path
            $imagePaths = [
                'pdf' => asset('files/pdf.jpg'),
                'xlsx' => asset('files/xlsx.jpg'),
                'zip' => asset('files/exe.jpg'),
                'word' => asset('files/word.jpg'),
                'ppt' => asset('files/ppt.jpg'),
                'image' => asset($file->path), // Display actual image
                'file' => asset('files/file.png'),
            ];

            $fileList[] = [
                'id' => $file->id,
                'name' => $file->name,
                'path' => asset($file->path),
                'image_path' => $imagePaths[$type] ?? asset('files/file.png'),
                'type' => $type,
            ];
        }

        return response()->json($fileList);
    }

    /**
     * Download a single file by id
     */
    public function downloadFile($id)
    {
        $file = FileSync::findOrFail($id);
        $filePath = public_path($file->path);
        if (!file_exists($filePath) || $file->type !== 'file') {
            abort(404, 'File not found.');
        }
        return response()->download($filePath, $file->name);
    }
}

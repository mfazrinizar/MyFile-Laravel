<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Upload a file.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max size
        ]);

        $file = $request->file('file');
        $path = $file->storeAs('uploads', Str::uuid() . '.' . $file->getClientOriginalExtension(), 'public');

        $uploadedFile = File::create([
            'user_id' => auth()->id(),
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'size' => $file->getSize(),
        ]);

        return response()->json($uploadedFile, 201);
    }

    /**
     * Get a file by ID.
     */
    public function show($id)
    {
        $file = File::findOrFail($id);
        return response()->json($file);
    }

    /**
     * Delete a file.
     */
    public function destroy($id)
    {
        $file = File::findOrFail($id);
        Storage::disk('public')->delete($file->path);
        $file->delete();

        return response()->json(['message' => 'File deleted successfully']);
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Share;
use App\Models\File;
use App\Models\Directory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class ShareController extends Controller
{
    /**
     * Share a file.
     */
    public function shareFile(Request $request, $fileId)
    {
        $validated = $request->validate([
            'is_public' => 'required|boolean',
        ]);

        $file = File::findOrFail($fileId);

        $share = Share::create([
            'user_id' => auth()->id(),
            'file_id' => $file->id,
            'slug' => Str::uuid(),
            'is_public' => $validated['is_public'],
        ]);

        return response()->json($share, 201);
    }

    /**
     * Share a directory.
     */
    public function shareDirectory(Request $request, $directoryId)
    {
        $validated = $request->validate([
            'is_public' => 'required|boolean',
        ]);

        $directory = Directory::findOrFail($directoryId);

        $share = Share::create([
            'user_id' => auth()->id(),
            'directory_id' => $directory->id,
            'slug' => Str::uuid(),
            'is_public' => $validated['is_public'],
        ]);

        return response()->json($share, 201);
    }

    /**
     * Get a public link for a shared file or directory.
     */
    public function publicLink($slug)
    {
        $share = Share::where('slug', $slug)->firstOrFail();

        // Check if it's public and return the shared resource
        if ($share->is_public) {
            $resource = $share->file_id ? $share->file : $share->directory;
            return response()->json($resource);
        }

        return response()->json(['message' => 'This resource is not public.'], 403);
    }

    /**
     * Unshare a file or directory.
     */
    public function unshare($slug)
    {
        $share = Share::where('slug', $slug)->firstOrFail();
        $share->delete();

        return response()->json(['message' => 'Resource unshared successfully']);
    }

    public function show($slug)
    {
        $share = Share::where('slug', $slug)->firstOrFail();

        // Check if the resource is public
        if (!$share->is_public) {
            abort(403, 'This resource is not public.');
        }

        // Determine if the shared resource is a file or directory
        $resource = $share->file_id ? $share->file : $share->directory;

        Log::info('Shared resource:', ['resource' => $resource]);


        return view('share.show', [
            'resource' => $resource,
            'isFile' => $share->file_id !== null,
        ]);
    }

    public function downloadFile($fileId)
    {
        $file = File::findOrFail($fileId);

        return response()->download(storage_path('app/public/' . $file->path), $file->name);
    }
}

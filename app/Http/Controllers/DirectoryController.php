<?php

namespace App\Http\Controllers;

use App\Models\Directory;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    /**
     * Create a new directory.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|uuid|exists:directories,id',
        ]);

        $directory = Directory::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return response()->json($directory, 201);
    }

    /**
     * Get a list of directories for the authenticated user.
     */
    public function index()
    {
        $directories = Directory::where('user_id', auth()->id())->get();
        return response()->json($directories);
    }

    /**
     * Get a specific directory.
     */
    public function show($id)
    {
        $directory = Directory::where('user_id', auth()->id())->findOrFail($id);
        return response()->json($directory);
    }

    /**
     * Delete a directory.
     */
    public function destroy($id)
    {
        $directory = Directory::where('user_id', auth()->id())->findOrFail($id);
        $directory->delete();

        return response()->json(['message' => 'Directory deleted successfully']);
    }
}


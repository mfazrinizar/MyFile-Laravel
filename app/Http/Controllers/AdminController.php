<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\File;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * List all user accounts.
     */
    public function listUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Update the storage limit for a user.
     */
    public function updateStorageLimit(Request $request, $userId)
    {
        $validated = $request->validate([
            'storage_limit' => 'required|integer|min:0',
        ]);

        $user = User::findOrFail($userId);
        $user->max_storage = $validated['storage_limit'] * 1024 * 1024; // Convert MB to bytes
        $user->save();

        return redirect()->back()->with('success', 'Storage limit updated successfully.');
    }

    /**
     * Deactivate a user account.
     */
    public function deactivateUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->is_active = false;
        $user->save();

        return response()->json(['message' => 'User account deactivated successfully']);
    }

    /**
     * Delete a user account and all associated data.
     */
    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return response()->json(['message' => 'User account deleted successfully']);
    }

    /**
     * Delete a public file.
     */
    public function deletePublicFile($fileId)
    {
        $file = File::findOrFail($fileId);

        if (!$file->is_public) {
            return response()->json(['message' => 'File is not public'], 403);
        }

        $file->delete();

        return response()->json(['message' => 'Public file deleted successfully']);
    }
}

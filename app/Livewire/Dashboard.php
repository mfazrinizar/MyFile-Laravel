<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; 
use App\Models\File;
use App\Models\Directory;
use App\Models\Share;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Masmerise\Toaster\Toaster;



class Dashboard extends Component
{
    use WithFileUploads;

    public $directories;
    public $rootFiles;
    public $currentDirectoryId = null;
    public $newDirectoryName;
    public $uploadedFile;
    public $showUploadModal = false;
    public $showCreateDirectoryModal = false;
    public $shareLink = null;
    public $deleteFileId = null;
    public $deleteDirectoryId = null;
    public $showShareLinkModal = false;
    public $deletedDirectoryName = null;
    public $deletedFileName = null;
    public $showDeleteModal = null;


    public function mount()
    {
        $this->loadDirectories();
    }

    public function loadDirectories()
    {
        // Load root-level directories
        $this->directories = Directory::with(['children', 'files'])
            ->whereNull('parent_id')
            ->where('user_id', auth()->id())
            ->get();

        // Load root-level files
        $this->rootFiles = File::whereNull('directory_id')
            ->where('user_id', auth()->id())
            ->get();
    }

    public function openUploadModal($directoryId = null)
    {
        $this->currentDirectoryId = $directoryId;
        $this->showUploadModal = true;
    }

    public function openCreateDirectoryModal($directoryId = null)
    {
        $this->currentDirectoryId = $directoryId;
        $this->showCreateDirectoryModal = true;
    }

    public function openDeleteDirectoryModal($directoryId = null)
    {
        $this->deleteDirectoryId = $directoryId;
        $this->deleteFileId = null;
        $this->showDeleteModal = true;
    }

    public function openDeleteFileModal($fileId = null)
    {
        $this->deleteFileId = $fileId;
        $this->deleteDirectoryId = null;
        $this->showDeleteModal = true;
    }


    public function createDirectory()
    {
        $this->validate([
            'newDirectoryName' => 'required|string|max:255',
        ]);

        Directory::create([
            'user_id' => auth()->id(),
            'name' => $this->newDirectoryName,
            'parent_id' => $this->currentDirectoryId,
        ]);

        $this->loadDirectories(); // Refresh directories
        $this->showCreateDirectoryModal = false;
        $this->newDirectoryName = '';
        Toaster::success('Directory created successfully.');
        session()->flash('success', 'Directory created successfully.');
    }

    public function uploadFile()
    {
        $this->validate([
            'uploadedFile' => 'required|file|max:10240000',
        ]);

        $path = $this->uploadedFile->store('uploads', 'public');

        File::create([
            'user_id' => auth()->id(),
            'name' => $this->uploadedFile->getClientOriginalName(),
            'path' => $path,
            'size' => $this->uploadedFile->getSize(),
            'directory_id' => $this->currentDirectoryId,
        ]);

        $this->loadDirectories();
        $this->showUploadModal = false;
        $this->uploadedFile = null;
        Toaster::success('File uploaded successfully.');
        session()->flash('success', 'File uploaded successfully.');
    }

    public function downloadFile($fileId)
    {
        $file = File::where('id', $fileId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        Toaster::success("{$file->name} Download Starts");

        return response()->download(storage_path('app/public/' . $file->path), $file->name);
    }

    public function toggleFilePrivacy($fileId)
    {
        $file = File::where('id', $fileId)->where('user_id', auth()->id())->firstOrFail();

        if ($file->share) {
            $file->share->delete();
            Toaster::success("{$file->name} Successfully Made Private");
        } else {
            Share::create([
                'user_id' => auth()->id(),
                'file_id' => $file->id,
                'slug' => Str::uuid(),
                'is_public' => true,
            ]);
            Toaster::success("{$file->name} Successfully Made Public");
        }

        $this->loadDirectories();
    }

    public function toggleDirectoryPrivacy($directoryId)
    {
        $directory = Directory::where('id', $directoryId)->where('user_id', auth()->id())->firstOrFail();

        if ($directory->share) {
            $directory->share->delete();
            Toaster::success("{$directory->name} Successfully Made Private");
        } else {
            Share::create([
                'user_id' => auth()->id(),
                'directory_id' => $directory->id,
                'slug' => Str::uuid(),
                'is_public' => true,
            ]);
            Toaster::success("{$directory->name} Successfully Made Private");
        }

        $this->loadDirectories();
    }

    public function generateFileShareLink($fileId)
    {
        $file = File::where('id', $fileId)->where('user_id', auth()->id())->firstOrFail();

        $share = Share::updateOrCreate(
            ['file_id' => $file->id, 'user_id' => auth()->id()],
            [
                'slug' => Str::uuid(),
                'is_public' => true,
            ]
        );

        $this->shareLink = route('share.show', $share->slug);
        $this->showShareLinkModal = true;
    }

    public function generateDirectoryShareLink($directoryId)
    {
        $directory = Directory::where('id', $directoryId)->where('user_id', auth()->id())->firstOrFail();

        $share = Share::updateOrCreate(
            ['directory_id' => $directory->id, 'user_id' => auth()->id()],
            [
                'slug' => Str::uuid(),
                'is_public' => true,
            ]
        );

        $this->shareLink = route('share.show', $share->slug);
        $this->showShareLinkModal = true;
    }

    public function copyToClipboard($link)
    {
        $this->dispatch('copy-to-clipboard', ['text' => $link]);
        session()->flash('success', __('Link copied to clipboard.'));
    }

    protected function recursiveDeleteDirectory($directory)
    {
        foreach ($directory->files as $file) {
            $file->delete();
        }
        foreach ($directory->children as $child) {
            $this->recursiveDeleteDirectory($child);
            $child->delete();
        }
    }

    public function delete()
    {
        if ($this->deleteFileId) {
            $file = File::findOrFail($this->deleteFileId);
            $this->deletedFileName = $file->name;
            Storage::disk('public')->delete($file->path);
            $file->delete();
            $this->deleteFileId = null;
            Toaster::success("{$this->deletedFileName} Successfully Deleted");
        }

        if ($this->deleteDirectoryId) {
            $directory = Directory::findOrFail($this->deleteDirectoryId);
            $this->deletedDirectoryName = $directory->name;
            $this->recursiveDeleteDirectory($directory);
            $directory->delete();
            $this->deleteDirectoryId = null;
            Toaster::success("{$this->deletedDirectoryName} Successfully Deleted");
        }
        $this->showDeleteModal = false;

        $this->loadDirectories();
    }

    public function render()
    {
        return view('dashboard');
    }
}

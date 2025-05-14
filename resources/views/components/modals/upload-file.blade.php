 <!-- Upload File Modal -->
@props(['showUploadModal', 'uploadedFile'])

 <flux:modal wire:model="showUploadModal">
     <form wire:submit.prevent="uploadFile">
         <h2 class="text-xl font-bold">{{ __('Upload File') }}</h2>
         <input type="file" wire:model="uploadedFile" class="mt-4">
         <div class="mt-6 flex justify-end gap-4">
             <flux:button variant="filled" wire:click="$set('showUploadModal', false)">{{ __('Cancel') }}
             </flux:button>
             <flux:button variant="primary" type="submit">{{ __('Upload') }}</flux:button>
         </div>
     </form>
 </flux:modal>

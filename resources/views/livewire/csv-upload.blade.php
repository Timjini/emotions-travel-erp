<form wire:submit.prevent="importCsv" enctype="multipart/form-data">
    <input type="file" wire:model="csvFile">
    <button type="submit">Upload</button>
    <div wire:loading wire:target="csvFile">Uploading file...</div>
</form>

@props(['id', 'name', 'label', 'required' => false, 'accept' => 'image/*'])

<div>
    <x-input-label for="{{ $id }}" :value="$label" />
    <div class="mt-1 flex items-center">
        <label for="{{ $id }}" class="relative cursor-pointer">
            <div class="flex flex-col items-center justify-center px-4 py-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-gray-400 transition duration-150 ease-in-out">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="mt-2 text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    Upload a file
                </span>
                <input 
                    id="{{ $id }}" 
                    name="{{ $name }}" 
                    type="file" 
                    class="sr-only" 
                    accept="{{ $accept }}"
                    {{ $required ? 'required' : '' }}
                >
                <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 5MB</p>
            </div>
        </label>
    </div>
    <div id="{{ $id }}-preview" class="mt-2 hidden">
        <img id="{{ $id }}-preview-image" class="h-32 rounded-lg object-cover" src="#" alt="Preview">
    </div>
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>

<script>
document.getElementById('{{ $id }}').addEventListener('change', function(e) {
    const file = this.files[0];
    const previewContainer = document.getElementById('{{ $id }}-preview');
    const previewImage = document.getElementById('{{ $id }}-preview-image');

    if (!file) {
        previewContainer.classList.add('hidden');
        return;
    }

    // Only allow image files
    if (!file.type.startsWith('image/')) {
        alert('The logo must be an image.');
        this.value = '';
        previewContainer.classList.add('hidden');
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        previewImage.src = e.target.result;
        previewContainer.classList.remove('hidden');
    }
    reader.readAsDataURL(file);
});
</script>

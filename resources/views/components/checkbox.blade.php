<input type="checkbox" id="is_active" name="is_active" value="1" 
    {{ old('is_active', true) ? 'checked' : '' }} 
    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />

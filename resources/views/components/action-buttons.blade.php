@props([
    'viewRoute' => null,
    'editRoute' => null,
    'deleteRoute' => null,
    'viewTooltip' => 'View',
    'editTooltip' => 'Edit',
    'deleteTooltip' => 'Delete',
])

<div class="flex items-center justify-center space-x-2">
    @if($viewRoute)
        <a href="{{ $viewRoute }}" class="p-1 text-blue-600 hover:text-blue-800 rounded-full hover:bg-blue-50" title="{{ $viewTooltip }}">
            <x-icons.view class="h-5 w-5" />
        </a>
    @endif
    
    @if($editRoute)
        <a href="{{ $editRoute }}" class="p-1 text-green-600 hover:text-green-800 rounded-full hover:bg-green-50" title="{{ $editTooltip }}">
            <x-icons.edit class="h-5 w-5" />
        </a>
    @endif
    
    @if($deleteRoute)
        <form method="POST" action="{{ $deleteRoute }}" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-1 text-red-600 hover:text-red-800 rounded-full hover:bg-red-50" title="{{ $deleteTooltip }}" onclick="return confirm('Are you sure?')">
                <x-icons.trash class="h-5 w-5" />
            </button>
        </form>
    @endif
</div>
@props(['category'])

@php
    // Handle both enum objects and strings
    $categoryValue = $category instanceof \App\Enums\Supplier\SupplierCategory ? $category->value : $category;
    
    // Format the display text
    $displayText = ucwords(str_replace('_', ' ', $categoryValue));
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
    {{ $displayText }}
</span>
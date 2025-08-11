@props(['language'])

@php
    $languageNames = [
        'en' => 'English',
        'es' => 'Spanish',
        'fr' => 'French',
        'de' => 'German',
        // Add more as needed
    ];
    
    $name = $languageNames[$language] ?? strtoupper($language);
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
    {{ $name }}
</span>
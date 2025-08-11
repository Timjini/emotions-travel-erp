@props(['source'])

@php
    $sourceColors = [
        'website' => 'bg-green-100 text-green-800',
        'referral' => 'bg-blue-100 text-blue-800',
        'social' => 'bg-purple-100 text-purple-800',
        'event' => 'bg-red-100 text-red-800',
        'other' => 'bg-gray-100 text-gray-800',
    ];
    
    $color = $sourceColors[strtolower($source)] ?? 'bg-gray-100 text-gray-800';
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
    {{ ucfirst($source) }}
</span>
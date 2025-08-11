@props(['type'])

@php
    // Define colors and labels for all customer types
    $typeStyles = [
        'client' => [
            'color' => 'bg-blue-100 text-blue-800',
            'label' => 'Client'
        ],
        'supplier' => [
            'color' => 'bg-green-100 text-green-800',
            'label' => 'Supplier'
        ],
        'client_and_supplier' => [
            'color' => 'bg-indigo-100 text-indigo-800',
            'label' => 'Client & Supplier'
        ],
        'bank' => [
            'color' => 'bg-yellow-100 text-yellow-800',
            'label' => 'Bank'
        ],
        'accommodation' => [
            'color' => 'bg-purple-100 text-purple-800',
            'label' => 'Accommodation'
        ],
        'restaurant' => [
            'color' => 'bg-red-100 text-red-800',
            'label' => 'Restaurant'
        ],
        'tour_operator' => [
            'color' => 'bg-pink-100 text-pink-800',
            'label' => 'Tour Operator'
        ],
        'transport' => [
            'color' => 'bg-orange-100 text-orange-800',
            'label' => 'Transport'
        ],
        'other' => [
            'color' => 'bg-gray-100 text-gray-800',
            'label' => 'Other'
        ],
        'individual' => [
            'color' => 'bg-blue-100 text-blue-800',
            'label' => 'Individual'
        ],
        'business' => [
            'color' => 'bg-purple-100 text-purple-800',
            'label' => 'Business'
        ]
    ];

    // Handle both enum objects and strings
    $typeValue = $type instanceof \App\Enums\Supplier\SupplierType ? $type->value : $type;
    
    // Get the style or fallback to default
    $style = $typeStyles[$typeValue] ?? [
        'color' => 'bg-gray-100 text-gray-800',
        'label' => ucfirst(str_replace('_', ' ', $typeValue))
    ];
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $style['color'] }}">
    {{ $style['label'] }}
</span>
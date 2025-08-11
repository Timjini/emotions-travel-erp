@props(['status'])

@php
    $statusColors = [
        'active' => 'bg-green-100 text-green-800',
        'inactive' => 'bg-gray-100 text-gray-800',
        'pending' => 'bg-yellow-100 text-yellow-800',
        'suspended' => 'bg-orange-100 text-orange-800',
        'blocked' => 'bg-red-100 text-red-800',
    ];
    
    // Get the string value from the enum
    $statusValue = $status instanceof \App\Enums\Supplier\SupplierStatus ? $status->value : $status;
    
    // Use the enum's label() method if available, otherwise fall back to our array
    $text = $status instanceof \App\Enums\Supplier\SupplierStatus 
        ? $status->label() 
        : ([
            'active' => 'Active',
            'inactive' => 'Inactive',
            'pending' => 'Pending',
            'suspended' => 'Suspended',
            'blocked' => 'Blocked',
        ][$statusValue] ?? ucfirst($statusValue));
    
    $color = $statusColors[$statusValue] ?? 'bg-gray-100 text-gray-800';
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
    {{ $text }}
</span>
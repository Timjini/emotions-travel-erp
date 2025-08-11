@props(['phone', 'label' => null])

<div class="inline-flex items-center bg-blue-50 text-blue-700 px-2.5 py-0.5 rounded-full text-xs">
    @if($label)
        <span class="mr-1 font-medium">{{ $label }}:</span>
    @endif
    <a href="tel:{{ $phone }}" class="hover:text-blue-800">{{ $phone }}</a>
</div>
<a {{ $attributes->merge([
        'class' => 'inline-flex items-center text-sm font-medium px-4 py-2 border border-[#E5E7EB] rounded-xl hover:bg-[#F7F9FA] transition'
    ]) }}>
    {{ $slot }}
</a>

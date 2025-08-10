@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'mt-2 rounded bg-gray-50 border text-gray-900  block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5']) }}>

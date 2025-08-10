@props(['type' => 'info', 'message' => null])

<div {{ $attributes->merge(['class' => "alert alert-{$type}"]) }}>
    {{ $message ?? $slot }}
</div>
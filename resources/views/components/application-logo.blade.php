@props(['type' => 'original'])

@php
$src = match($type) {
    'white' => asset('logo-white.png'),
    'black' => asset('logo-black.png'),
    'transparent' => asset('logo-transparent.png'),
    default => asset('favicon.png'),
};
@endphp

<img src="{{ $src }}" {{ $attributes }} alt="Wirojek Logo" />

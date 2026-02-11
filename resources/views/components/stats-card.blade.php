@props(['title', 'value', 'description' => null, 'icon' => null, 'color' => 'primary'])

@php
    $colorClasses = [
        'primary' => 'stat-primary',
        'secondary' => 'stat-secondary',
        'accent' => 'stat-accent',
        'success' => 'stat-success',
        'warning' => 'stat-warning',
        'error' => 'stat-error',
        'info' => 'stat-info',
    ];
@endphp

<div class="stat {{ $colorClasses[$color] ?? '' }}">
    @if($icon)
    <div class="stat-figure text-{{ $color }}">
        {!! $icon !!}
    </div>
    @endif
    
    <div class="stat-title">{{ $title }}</div>
    <div class="stat-value">{{ $value }}</div>
    
    @if($description)
    <div class="stat-desc">{{ $description }}</div>
    @endif
</div>
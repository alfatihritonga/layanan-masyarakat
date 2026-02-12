@props(['status' => null, 'urgency' => null, 'text' => null])

@php
    $classes = 'badge';
    $displayText = '';
    
    if ($status) {
        $statusConfig = [
            'pending' => ['class' => 'badge-warning', 'text' => 'Pending'],
            'verified' => ['class' => 'badge-info', 'text' => 'Terverifikasi'],
            'in_progress' => ['class' => 'badge-primary', 'text' => 'Dalam Proses'],
            'resolved' => ['class' => 'badge-success', 'text' => 'Selesai'],
            'rejected' => ['class' => 'badge-error', 'text' => 'Ditolak'],
        ];
        
        $config = $statusConfig[$status] ?? ['class' => 'badge-ghost', 'text' => ucfirst($status)];
        $classes .= ' ' . $config['class'];
        $displayText = $config['text'];
    }
    
    if ($urgency) {
        $urgencyConfig = [
            'low' => ['class' => 'badge-ghost', 'text' => 'Rendah'],
            'medium' => ['class' => 'badge-warning', 'text' => 'Sedang'],
            'high' => ['class' => 'badge-error', 'text' => 'Tinggi'],
            'critical' => ['class' => 'badge-error animate-pulse', 'text' => 'Kritis'],
        ];
        
        $config = $urgencyConfig[$urgency] ?? ['class' => 'badge-ghost', 'text' => ucfirst($urgency)];
        $classes .= ' ' . $config['class'];
        $displayText = $config['text'];
    }
    
    if ($text) {
        $displayText = $text;
    }
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{-- <span class="status"></span> --}}
    {{ $displayText }}
</span>
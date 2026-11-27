@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'color' => 'primary',
    'shadow' => true,
    'bordered' => false,
])

<div class="card {{ $shadow ? 'shadow-sm' : '' }} {{ $bordered ? 'border-0' : '' }}">
    @if($title || $icon)
    <div class="card-header d-flex justify-content-between align-items-center {{ $bordered ? 'border-0' : '' }}">
        <div>
            @if($icon)
            <div class="d-flex align-items-center gap-2">
                <div class="bg-{{ $color }} bg-opacity-10 p-2 rounded">
                    <i class="{{ $icon }} text-{{ $color }}"></i>
                </div>
                @if($title)
                <h6 class="fw-semibold mb-0">{{ $title }}</h6>
                @endif
            </div>
            @else
            @if($title)
            <h6 class="fw-semibold mb-0">{{ $title }}</h6>
            @endif
            @endif
            @if($subtitle)
            <small class="text-muted">{{ $subtitle }}</small>
            @endif
        </div>
        {{ $slot }}
    </div>
    @endif
    
    <div class="card-body {{ $title ? '' : 'pt-4' }}">
        {{ $slot }}
    </div>
</div>

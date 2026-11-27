@props([
    'title' => 'Filter Data',
    'filters' => [],
    'showReset' => true,
    'resetUrl' => request()->url(),
    'compact' => false,
])

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-semibold mb-0">{{ $title }}</h6>
            @if($showReset)
            <a href="{{ $resetUrl }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-counterclockwise"></i> Reset
            </a>
            @endif
        </div>
        
        <form method="GET" class="row g-3">
            @foreach($filters as $filter)
            <div class="{{ $filter['colClass'] ?? 'col-md-3' }}">
                @if($filter['type'] === 'select')
                <label class="form-label fw-semibold text-sm">{{ $filter['label'] }}</label>
                <select name="{{ $filter['name'] }}" class="form-select {{ $filter['class'] ?? '' }}">
                    <option value="">{{ $filter['placeholder'] ?? 'Semua' }}</option>
                    @foreach($filter['options'] as $value => $label)
                    <option value="{{ $value }}" {{ (request($filter['name']) == $value) ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @elseif($filter['type'] === 'text')
                <label class="form-label fw-semibold text-sm">{{ $filter['label'] }}</label>
                <input type="text" name="{{ $filter['name'] }}" 
                       class="form-control {{ $filter['class'] ?? '' }}" 
                       placeholder="{{ $filter['placeholder'] ?? '' }}"
                       value="{{ request($filter['name']) }}">
                @elseif($filter['type'] === 'date')
                <label class="form-label fw-semibold text-sm">{{ $filter['label'] }}</label>
                <input type="date" name="{{ $filter['name'] }}" 
                       class="form-control {{ $filter['class'] ?? '' }}"
                       value="{{ request($filter['name']) }}">
                @elseif($filter['type'] === 'number')
                <label class="form-label fw-semibold text-sm">{{ $filter['label'] }}</label>
                <input type="number" name="{{ $filter['name'] }}" 
                       class="form-control {{ $filter['class'] ?? '' }}" 
                       placeholder="{{ $filter['placeholder'] ?? '' }}"
                       value="{{ request($filter['name']) }}">
                @endif
            </div>
            @endforeach
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>
</div>

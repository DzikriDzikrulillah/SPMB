@props([
    'headers' => [],
    'rows' => [],
    'emptyMessage' => 'Tidak ada data tersedia',
    'striped' => true,
    'hover' => true,
    'bordered' => false,
    'responsive' => true,
])

@if($responsive)
<div class="table-responsive">
@endif

<table class="table {{ $striped ? 'table-striped' : '' }} {{ $hover ? 'table-hover' : '' }} {{ $bordered ? 'table-bordered' : '' }} align-middle">
    <thead class="table-light">
        <tr>
            @foreach($headers as $header)
            <th class="{{ $header['class'] ?? '' }}">{{ $header['title'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @if($rows->isEmpty())
        <tr>
            <td colspan="{{ count($headers) }}" class="text-center py-5">
                <div class="text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    <p>{{ $emptyMessage }}</p>
                </div>
            </td>
        </tr>
        @else
        @foreach($rows as $row)
        <tr>
            @foreach($headers as $header)
            <td class="{{ $header['cellClass'] ?? '' }}">
                @isset($header['slot'])
                    {{ $header['slot']($row) }}
                @else
                    {{ $row->{$header['key']} }}
                @endisset
            </td>
            @endforeach
        </tr>
        @endforeach
        @endif
    </tbody>
</table>

@if($responsive)
</div>
@endif

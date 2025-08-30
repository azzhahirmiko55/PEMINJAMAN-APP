<div class="m-4">
    <div class="d-grid gap-2" style="grid-template-columns: repeat(5, auto);">
        @if ($type === 'kendaraan')
        @foreach ($main as $item)
        <span class="badge
                    {{ $item->status == 1 ? 'bg-danger' : 'bg-success' }} px-3 py-2 fs-6">
            {{ $item->no_plat }} - {{ $item->jenis_kendaraan }}
        </span>
        @endforeach
        @else
        @foreach ($main as $item)
        <span class="badge
                    {{ $item->status == 1 ? 'bg-danger' : 'bg-success' }} px-3 py-2 fs-6">
            {{ $item->nama_ruangan }} - {{ $item->warna_ruangan }}
        </span>
        @endforeach
        @endif
    </div>
</div>

@extends('layouts.app')

@section('content')
<style>
    .stat-card {
        transition: transform .2s ease, box-shadow .2s ease;
        border-radius: 14px;
        background: linear-gradient(180deg, rgba(0, 0, 0, .00), rgba(0, 0, 0, .00));
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, .08);
    }

    .icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: rgba(13, 110, 253, .08);
        color: #0d6efd;
        font-size: 22px;
    }

    .icon-wrap i {
        line-height: 0;
    }

    .icon-success {
        background: rgba(25, 135, 84, .10);
        color: #198754;
    }

    .icon-info {
        background: rgba(13, 202, 240, .12);
        color: #0dcaf0;
    }

    .icon-warning {
        background: rgba(255, 193, 7, .12);
        color: #ffc107;
    }

    [data-pc-theme="dark"] .stat-card {
        background: rgba(255, 255, 255, .03);
    }
</style>
<div class="row g-3">
    {{-- Card 1: Total Peminjaman --}}
    <div class="col-12 col-sm-4 col-xl-4">
        <div class="card stat-card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <div class="icon-wrap me-3">
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#unordered-list"></use>
                        </svg>
                    </i>
                </div>
                <div class="flex-grow-1">
                    <div class="label text-muted small mb-1">Total Peminjaman</div>
                    <div class="h3 mb-0">
                        <span class="counter" data-target="{{ $totalAll ?? 0 }}">{{ $totalAll ?? 0 }}</span>
                    </div>
                </div>
                <span class="badge bg-primary-subtle text-primary d-none d-md-inline">Semua</span>
            </div>
        </div>
    </div>

    {{-- Card 2: Disetujui --}}
    <div class="col-12 col-sm-4 col-xl-4">
        <div class="card stat-card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <div class="icon-wrap me-3 icon-success">
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#check-circle"></use>
                        </svg>
                    </i>
                </div>
                <div class="flex-grow-1">
                    <div class="label text-muted small mb-1">Total Disetujui</div>
                    <div class="h3 mb-0">
                        <span class="counter" data-target="{{ $totalApproved ?? 0 }}">{{ $totalApproved ?? 0 }}</span>
                    </div>
                </div>
                <span class="badge bg-success-subtle text-success d-none d-md-inline">Disetujui</span>
            </div>
        </div>
    </div>

    {{-- Card 3: Pengembalian --}}
    <div class="col-12 col-sm-4 col-xl-4">
        <div class="card stat-card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <div class="icon-wrap me-3 text-info">
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#rollback"></use>
                        </svg>
                    </i>
                </div>
                <div class="flex-grow-1">
                    <div class="label text-muted small mb-1">Total Pengembalian</div>
                    <div class="h3 mb-0">
                        <span class="counter" data-target="{{ $totalPengembalian ?? 0 }}">{{ $totalPengembalian ?? 0
                            }}</span>
                    </div>
                </div>
                <span class="badge bg-info-subtle text-info d-none d-md-inline">Pengembalian</span>
            </div>
        </div>
    </div>

    {{-- Card 3: Peminjaman Kendaraan --}}
    <div class="col-12 col-sm-6 col-xl-6">
        <div class="card stat-card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <div class="icon-wrap me-3 text-info">
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#car"></use>
                        </svg>
                    </i>
                </div>
                <div class="flex-grow-1">
                    <div class="label text-muted small mb-1">Peminjaman Kendaraan</div>
                    <div class="h3 mb-0">
                        <span class="counter" data-target="{{ $totalKendaraan ?? 0 }}">{{ $totalKendaraan ?? 0 }}</span>
                    </div>
                </div>
                <span class="badge bg-info-subtle text-info d-none d-md-inline">Kendaraan</span>
            </div>
        </div>
    </div>

    {{-- Card 4: Peminjaman Ruangan --}}
    <div class="col-12 col-sm-6 col-xl-6">
        <div class="card stat-card shadow-sm border-0">
            <div class="card-body d-flex align-items-center">
                <div class="icon-wrap me-3 icon-warning">
                    <i class="pc-micon">
                        <svg class="pc-icon">
                            <use xlink:href="#home"></use>
                        </svg>
                    </i>
                </div>
                <div class="flex-grow-1">
                    <div class="label text-muted small mb-1">Peminjaman Ruangan</div>
                    <div class="h3 mb-0">
                        <span class="counter" data-target="{{ $totalRuangan ?? 0 }}">{{ $totalRuangan ?? 0 }}</span>
                    </div>
                </div>
                <span class="badge bg-warning-subtle text-warning d-none d-md-inline">Ruangan</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h5 class="mb-3">Peminjaman Hari Ini</h5>
        <div class="card">
            @php
            // Map status => badge warna + label
            $statusMap = [
            0 => ['class' => 'warning', 'text' => 'Menunggu'],
            1 => ['class' => 'success', 'text' => 'Disetujui'],
            2 => ['class' => 'danger', 'text' => 'Ditolak'],
            3 => ['class' => 'secondary','text' => 'Dibatalkan'],
            4 => ['class' => 'info', 'text' => 'Selesai'],
            ];

            // Map tipe => ikon + warna avatar halus
            $tipeMap = [
            'kendaraan' => ['icon' => 'ti ti-car', 'avatar' => ['text' => 'primary', 'bg' => 'bg-light-primary']],
            'ruangan' => ['icon' => 'ti ti-door', 'avatar' => ['text' => 'info', 'bg' => 'bg-light-info']],
            ];
            @endphp

            @if(($peminjamanToday ?? collect())->isEmpty())
            <div class="card-body text-center text-muted py-5">
                <div class="mb-2">
                    <div
                        class="avtar avtar-s rounded-circle text-secondary bg-light-secondary d-inline-grid place-items-center">
                        <i class="ti ti-calendar-time f-18"></i>
                    </div>
                </div>
                Belum ada peminjaman hari ini.
            </div>
            @else
            <div class="list-group list-group-flush">
                @foreach ($peminjamanToday as $row)
                @php
                $tipe = strtolower($row->tipe_peminjaman ?? '');
                $t = $tipeMap[$tipe] ?? ['icon' => 'ti ti-clipboard', 'avatar' =>
                ['text'=>'secondary','bg'=>'bg-light-secondary']];
                $s = $statusMap[$row->status] ?? ['class'=>'secondary','text'=>'-'];

                // Judul & subjudul item
                if ($tipe === 'kendaraan') {
                $title = ($row->no_plat ? $row->no_plat : '—') . ($row->jenis_kendaraan ? ' • ' . $row->jenis_kendaraan
                : '');
                $subtitle = 'Peminjam: ' . ($row->nama_pegawai ?? '—');
                } elseif ($tipe === 'ruangan') {
                $title = ($row->ruang_kode ? $row->ruang_kode . ' • ' : '') . ($row->ruang_nm ?? '—');
                $subtitle = 'Peminjam: ' . ($row->nama_pegawai ?? '—');
                } else {
                $title = 'Peminjaman #' . $row->id_peminjaman;
                $subtitle = 'Peminjam: ' . ($row->nama_pegawai ?? '—');
                }

                // Waktu tampilan
                $waktu = \Carbon\Carbon::parse($row->tanggal)->locale('id')->isoFormat('D MMM Y');
                $jam_mulai = \Carbon\Carbon::parse($row->jam_mulai)->locale('id')->isoFormat('HH:mm');
                $jam_selesai = \Carbon\Carbon::parse($row->jam_selesai)->locale('id')->isoFormat('HH:mm');
                @endphp

                <div class="list-group-item">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="avtar avtar-s rounded-circle {{ $t['avatar']['bg'] }} text-{{ $t['avatar']['text'] }}">
                                <i class="{{ $t['icon'] }} f-18"></i>
                            </div>
                        </div>

                        <div class="flex-grow-1 ms-3">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <h6 class="mb-0">{{ $title }}</h6>
                                <span class="badge bg-{{ $s['class'] }} align-middle">{{ $s['text'] }}</span>
                            </div>
                            <p class="mb-0 text-muted small">
                                {{ $subtitle }} &middot; {{ $waktu }}
                            </p>
                        </div>

                        <div class="flex-shrink-0 text-end">
                            {{ $jam_mulai }} - {{ $jam_selesai }}
                            {{-- <a href="{{ route('pegawai-peminjaman.show', $row->id_peminjaman) ?? '#' }}"
                                class="btn btn-light-primary btn-sm">
                                Detail
                            </a> --}}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>


@endsection

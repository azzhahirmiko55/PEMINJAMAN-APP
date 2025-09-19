{{-- <div class="m-4">
    <div class="d-grid gap-2" style="grid-template-columns: repeat(5, auto);">
        <span class="badge bg-success px-3 py-2 fs-6">
            Tersedia
        </span>
        <span class="badge bg-primary px-3 py-2 fs-6">
            Terbatas
        </span>
        <span class="badge bg-danger px-3 py-2 fs-6">
            Terpakai
        </span>
        <br>
        <br>
        <span></span>
        <br>
        <br>
        <span></span>
        <br>
        <span class="py-4"></span>
        <br>
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
</div> --}}

<div class="m-4">
    <div class="mb-2">
        <span class="badge bg-success px-3 py-2">Tersedia</span>
        <span class="badge bg-primary px-3 py-2">Terbatas</span>
        <span class="badge bg-danger px-3 py-2">Terpakai</span>
        <span class="text-muted small ms-2">
            ({{ \Carbon\Carbon::parse($date)->locale('ID')->isoFormat('dddd, D MMMM Y') }},
            {{ substr($windowStart,0,5) }}–{{ substr($windowEnd,0,5) }})
        </span>
    </div>

    {{-- Tersedia: tidak bisa diklik --}}
    <div class="mb-3">
        <div class="fw-semibold mb-1">Tersedia</div>
        <div class="d-grid gap-2" style="grid-template-columns: repeat(5, auto);">
            @forelse ($tersedia as $it)
            <span class="badge bg-success px-3 py-2">{{ $it['label'] }}</span>
            @empty
            <span class="text-muted">Tidak ada.</span>
            @endforelse
        </div>
    </div>

    {{-- Terbatas: bisa diklik untuk lihat daftar peminjam --}}
    <div class="mb-3">
        <div class="fw-semibold mb-1">Terbatas</div>
        <div class="d-grid gap-2" style="grid-template-columns: repeat(5, auto);">
            @forelse ($terbatas as $it)
            <button type="button" class="badge bg-primary px-3 py-2 border-0" data-bookings='@json($it["bookings"])'
                data-label="{{ $it['label'] }}">
                {{ $it['label'] }}
            </button>
            @empty
            <span class="text-muted">Tidak ada.</span>
            @endforelse
        </div>
    </div>

    {{-- Terpakai: bisa diklik untuk lihat daftar peminjam --}}
    <div class="mb-3">
        <div class="fw-semibold mb-1">Terpakai</div>
        <div class="d-grid gap-2" style="grid-template-columns: repeat(5, auto);">
            @forelse ($terpakai as $it)
            <button type="button" class="badge bg-danger px-3 py-2 border-0" data-bookings='@json($it["bookings"])'
                data-label="{{ $it['label'] }}">
                {{ $it['label'] }}
            </button>
            @empty
            <span class="text-muted">Tidak ada.</span>
            @endforelse
        </div>
    </div>

    {{-- List detail muncul di bawah saat badge biru/merah diklik --}}
    <div id="list-wrapper" class="mt-3 d-none">
        <div class="card">
            <div class="card-header"><strong id="list-title">Daftar Peminjaman</strong></div>
            <div class="card-body p-2" id="list-container"></div>
        </div>
    </div>
</div>

<script>
    // Delegasi klik untuk elemen yang mungkin muncul belakangan (AJAX)
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('[data-bookings]'); // badge biru/merah
    if (!btn) return;

    const wrap   = document.getElementById('list-wrapper');
    const title  = document.getElementById('list-title');
    const listEl = document.getElementById('list-container');

    // Ambil data dari atribut
    const label    = btn.getAttribute('data-label') || 'Item';
    const bookings = JSON.parse(btn.getAttribute('data-bookings') || '[]');
    // console.log({ label, bookings });


    // Tampilkan judul
    if (title) title.textContent = label;

    // Render list
    if (listEl) {
      listEl.innerHTML = '';
      if (!bookings.length) {
        listEl.innerHTML = '<div class="text-muted">Tidak ada detail peminjaman.</div>';
      } else {
        // urutkan berdasarkan mulai
        bookings.sort((a,b) => (a.s||0) - (b.s||0));
        bookings.forEach(b => {
          const peminjam = b.peminjam || '-';
          const jm = b.jam_mulai || '';
          const js = b.jam_selesai || '';
          const id = b.id || '';
          listEl.insertAdjacentHTML('beforeend', `
            <div class="border-bottom py-1 d-flex justify-content-between">
              <div>
                <div><strong>${jm} - ${js}</strong></div>
                <div class="small text-muted">Peminjam: ${peminjam}</div>
              </div>
              <span class="small text-muted">#${id}</span>
            </div>
          `);
        });
      }
    }

    // Munculkan card list
    if (wrap) {
      wrap.classList.remove('d-none');
      wrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
</script>
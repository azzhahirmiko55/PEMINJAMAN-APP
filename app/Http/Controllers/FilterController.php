<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilterController extends Controller
{
    private string $sessionKey = 'filters.laporan';

    public function save(Request $request)
    {
        $data = $request->validate([
            'tanggal_awal'  => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_awal',
            'tipe_peminjaman' => 'nullable|string',
            'section_view' => 'nullable||in:-1,0,1',
            'status' => 'nullable|in:-1,0,1',
            'id_kendaraan' => 'nullable|exists:tb_kendaraan,id_kendaraan',
            'id_ruangan' => 'nullable|exists:tb_ruang_rapat,id_ruangrapat',
            'id_peminjam' => 'nullable|exists:tb_pegawai,id_pegawai',
            'pengembalian_st' => 'nullable|in:0,1',
        ]);

        session()->put($this->sessionKey, $data);

        return back()->with('success', 'Filter disimpan.');
    }

    public function reset()
    {
        session()->forget($this->sessionKey);
        return back()->with('success', 'Filter direset.');
    }

    public static function current(): array
    {
        return session('filters.laporan', []);
    }
}

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

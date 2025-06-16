<?php

namespace App\Http\Controllers;

use App\Models\DetailPelanggaran;
use App\Models\Pelanggar;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DetailPelanggaranController extends Controller
{
    public function show(string $id): View
    {
        $details = DB::table('detail_pelanggarans')
            ->join('pelanggars', 'detail_pelanggarans.id_pelanggar', '=', 'pelanggars.id')
            ->join('pelanggarans', 'detail_pelanggarans.id_pelanggaran', '=', 'pelanggarans.id')
            ->join('users', 'detail_pelanggarans.id_user', '=', 'users.id')
            ->select(
                'detail_pelanggarans.*',
                'pelanggars.id_siswa',
                'pelanggars.poin_pelanggar',
                'pelanggarans.jenis',
                'pelanggarans.konsekuensi',
                'pelanggarans.poin',
                'users.name'
            )
            ->where('detail_pelanggarans.id_pelanggar', $id)
            ->latest()
            ->paginate(10);

        $pelanggar = DB::table('pelanggars')
            ->join('siswas', 'pelanggars.id_siswa', '=', 'siswas.id')
            ->join('users', 'siswas.id_user', '=', 'users.id')
            ->select(
                'pelanggars.*',
                'siswas.image',
                'siswas.nis',
                'siswas.tingkatan',
                'siswas.jurusan',
                'siswas.kelas',
                'siswas.hp',
                'users.name',
                'users.email'
            )
            ->where('pelanggars.id', $id)
            ->first();

        return view('admin.detail.show', compact('details', 'pelanggar'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $detail = DetailPelanggaran::findOrFail($id);

        $detail->update([
            'status' => 1
        ]);

        // 🔧 FIX: menggunakan nama route yang tersedia
        return redirect()->route('detailPelanggar.show', $request->id_pelanggar)
                         ->with(['success' => 'Siswa Telah Diberikan Sanksi!']);
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $detail = DetailPelanggaran::findOrFail($id);

        $this->deletePoin($request->id_pelanggar, $request->poin_pelanggaran);

        $detail->delete();

        // 🔧 FIX: menggunakan nama route yang tersedia
        return redirect()->route('detailPelanggar.show', $request->id_pelanggar)
                         ->with(['success' => 'Data Berhasil Dihapus!']);
    }

    private function deletePoin($id_pelanggar, $poin_pelanggaran): void
    {
        $poin_sekarang = Pelanggar::where('id', $id_pelanggar)->value('poin_pelanggar');
        $poin_baru = max(0, $poin_sekarang - $poin_pelanggaran);

        $pelanggar = Pelanggar::findOrFail($id_pelanggar);
        $pelanggar->update([
            'poin_pelanggar' => $poin_baru
        ]);
    }
}

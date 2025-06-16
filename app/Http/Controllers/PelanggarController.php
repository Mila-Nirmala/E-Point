<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggar;
use App\Models\DetailPelanggaran;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PelanggarController extends Controller
{
    public function index(): View
{
    // Ambil semua ID siswa yang sudah menjadi pelanggar
    $id_pelanggars = DB::table('pelanggars')->pluck('id_siswa')->toArray();

    // Jika ada pencarian
    if (request('cari')) {
        $pelanggars = $this->searchPelanggar(request('cari'), $id_pelanggars);
    } else {
        // Default tampilkan semua pelanggar
        $pelanggars = DB::table('pelanggars')
            ->join('siswas', 'pelanggars.id_siswa', '=', 'siswas.id')
            ->join('users', 'siswas.id_user', '=', 'users.id')
            ->select(
                'pelanggars.id',
                'pelanggars.poin_pelanggar',
                'pelanggars.status',
                'pelanggars.status_pelanggar',
                'siswas.image', 'siswas.nis', 'siswas.tingkatan',
                'siswas.jurusan', 'siswas.kelas', 'siswas.hp',
                'users.name', 'users.email'
            )
            ->whereIn('siswas.id', $id_pelanggars)
            ->orderBy('pelanggars.created_at', 'desc')
            ->paginate(10);
        }

    
    return view('admin.pelanggar.index', compact('pelanggars'));
}


    public function searchPelanggar(string $cari, $id)
    {
        return DB::table('pelanggars')
            ->join('siswas', 'pelanggars.id_siswa', '=', 'siswas.id')
            ->join('users', 'siswas.id_user', '=', 'users.id')
            ->select('pelanggars.*', 'siswas.image', 'siswas.nis', 'siswas.tingkatan',
                'siswas.jurusan', 'siswas.kelas', 'siswas.hp', 'users.name', 'users.email')
            ->whereIn('siswas.id', $id)
            ->where(function ($query) use ($cari) {
                $query->where('users.name', 'like', '%' . $cari . '%')
                    ->orWhere('siswas.nis', 'like', '%' . $cari . '%');
            })
            ->orderBy('pelanggars.created_at', 'desc')
            ->paginate(10);
    }

    public function create(): View
    {
        $id_pelanggars = DB::table('pelanggars')->pluck('id_siswa')->toArray();

        $siswas = DB::table('siswas')
            ->join('users', 'siswas.id_user', '=', 'users.id')
            ->select('siswas.*', 'users.name', 'users.email')
            ->whereNotIn('siswas.id', $id_pelanggars)
            ->whereNotNull('siswas.image')
            ->latest()
            ->paginate(10);

        if (request('cari')) {
            $siswas = $this->searchSiswa(request('cari'), $id_pelanggars);
        }

        return view('admin.pelanggar.create', compact('siswas'));
    }

    public function searchSiswa(string $cari, $id)
    {
        return DB::table('siswas')
            ->join('users', 'siswas.id_user', '=', 'users.id')
            ->select('siswas.*', 'users.name', 'users.email')
            ->whereNotIn('siswas.id', $id)
            ->where(function ($query) use ($cari) {
                $query->where('users.name', 'like', '%' . $cari . '%')
                    ->orWhere('siswas.nis', 'like', '%' . $cari . '%');
            })
            ->latest()
            ->paginate(10);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_siswa' => 'required'
        ]);

        $pelanggar = Pelanggar::create([
            'id_siswa' => $request->id_siswa,
            'poin_pelanggar' => 0,
            'status_pelanggar' => 0,
            'status' => 0
        ]);

        return redirect()->route('pelanggar.show', $pelanggar->id);
    }

    public function show(string $id): View
    {
        $pelanggar = DB::table('pelanggars')
            ->join('siswas', 'pelanggars.id_siswa', '=', 'siswas.id')
            ->join('users', 'siswas.id_user', '=', 'users.id')
            ->select('pelanggars.*', 'siswas.image', 'siswas.nis', 'siswas.tingkatan',
                'siswas.jurusan', 'siswas.kelas', 'siswas.hp', 'users.name', 'users.email')
            ->where('pelanggars.id', $id)
            ->first();

        $pelanggarans = DB::table('pelanggarans')->latest()->paginate(10);

        if (request('cari')) {
            $pelanggarans = $this->searchPelanggaran(request('cari'));
        }

        $idUser = Auth::id();

        return view('admin.pelanggar.show', compact('pelanggar', 'pelanggarans', 'idUser'));
    }

    public function searchPelanggaran(string $cari)
    {
        return DB::table('pelanggarans')
            ->where(DB::raw('lower(jenis)'), 'like', '%' . strtolower($cari) . '%')
            ->paginate(10);
    }

    public function storePelanggaran(Request $request): RedirectResponse
    {
        $request->validate([
            'id_pelanggar' => 'required',
            'id_user' => 'required',
            'id_pelanggaran' => 'required'
        ]);

        DetailPelanggaran::create([
            'id_pelanggar' => $request->id_pelanggar,
            'id_user' => $request->id_user,
            'id_pelanggaran' => $request->id_pelanggaran,
            'status' => 0
        ]);

        $this->updatePoin($request->id_pelanggaran, $request->id_pelanggar);

        return redirect()->route('detailPelanggar.show', $request->id_pelanggar)
            ->with(['success' => 'Data Berhasil Disimpan']);
    }

    private function updatePoin(string $id_pelanggaran, string $id_pelanggar): void
    {
        $poin = $this->calculatedPoin($id_pelanggaran, $id_pelanggar);

        $datas = Pelanggar::findOrFail($id_pelanggar);
        $datas->update(['poin_pelanggar' => $poin]);

        $this->updateStatus($datas, $poin);
    }

    private function calculatedPoin(string $id_pelanggaran, string $id_pelanggar): int
    {
        $poin_pelanggaran = DB::table('pelanggarans')->where('id', $id_pelanggaran)->value('poin');
        $poin_pelanggar = DB::table('pelanggars')->where('id', $id_pelanggar)->value('poin_pelanggar');

        return $poin_pelanggar + $poin_pelanggaran;
    }

    private function updateStatus($datas, int $poin): void
    {
        $kategoriPelanggar = 0;

        if ($poin >= 15 && $poin < 20) $kategoriPelanggar = 1;
        elseif ($poin >= 20 && $poin < 30) $kategoriPelanggar = 2;
        elseif ($poin >= 30 && $poin < 40) $kategoriPelanggar = 3;
        elseif ($poin >= 40 && $poin < 50) $kategoriPelanggar = 4;
        elseif ($poin >= 50 && $poin < 100) $kategoriPelanggar = 5;
        elseif ($poin >= 100) $kategoriPelanggar = 6;

        if ($kategoriPelanggar > $datas->status_pelanggar && $datas->status == 2) {
            $datas->update([
                'status_pelanggar' => $kategoriPelanggar,
                'status' => 1
            ]);
        } elseif ($poin < 15) {
            $datas->update([
                'status_pelanggar' => 0,
                'status' => 0
            ]);
        }
    }

    public function statusTindak($id): RedirectResponse
{
    $datas = Pelanggar::findOrFail($id);

    $pelanggar = DB::table('pelanggars')
        ->join('siswas', 'pelanggars.id_siswa', '=', 'siswas.id')
        ->join('users', 'siswas.id_user', '=', 'users.id')
        ->select('users.name')
        ->where('pelanggars.id', $id)
        ->first();

    $datas->update(['status' => 2]);

    // Ambil name dengan pengecekan tipe data
    $name = $pelanggar->name ?? 'Pelajar';

    if (!is_string($name)) {
        $name = is_object($name) ? json_encode($name) : (string) $name;
    }

    return redirect()->route('pelanggar.index')->with(['success' => $name . ' Telah Ditindak!']);
}

    public function destroy($id): RedirectResponse
    {
        $this-> destroyPelanggaran($id);
        $post = Pelanggar::findOrFail($id);
        $post->delete();

        return redirect()->route('pelanggar.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function destroyPelanggaran(string $id): void
    {
        $pelanggaran = DB::table('detail_pelanggarans')->where('id_pelanggar', $id);
        $pelanggaran->delete();
    }
}

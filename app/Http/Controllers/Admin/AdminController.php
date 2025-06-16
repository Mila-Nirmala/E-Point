<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $pelanggars = $this->top10Pelanggar();      
        $hitung = $this->top10Pelanggaran();        
        list($jmlSiswas, $jmlPelanggars) = $this->countDash(); 
        return view('admin.dashboard', compact('pelanggars', 'hitung', 'jmlSiswas', 'jmlPelanggars'));
    }

    // Ambil 10 pelanggar dengan poin terbanyak
    public function top10Pelanggar()
    {
        $pelanggars = DB::table('pelanggars')
            ->join('siswas', 'pelanggars.id_siswa', '=', 'siswas.id')
            ->join('users', 'siswas.id_user', '=', 'users.id') // Perbaiki baris ini
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
            ->where('pelanggars.poin_pelanggar', '>=', 45)
            ->orderBy('pelanggars.poin_pelanggar', 'DESC')
            ->take(10)
            ->get();

        return $pelanggars;
    }

    // Ambil 10 jenis pelanggaran terbanyak
    public function top10Pelanggaran()
    {
        $hitung = DB::table('detail_pelanggarans')
            ->join('pelanggarans', 'detail_pelanggarans.id_pelanggaran', '=', 'pelanggarans.id')
            ->select(
                'detail_pelanggarans.id_pelanggaran',
                'pelanggarans.jenis',
                'pelanggarans.konsekuensi',
                'pelanggarans.poin',
                DB::raw('COUNT(*) as totals')
            )
            ->groupBy('detail_pelanggarans.id_pelanggaran', 'pelanggarans.jenis','pelanggarans.konsekuensi','pelanggarans.poin')
            ->orderByDesc('totals')
            ->take(10)
            ->get();

        return $hitung;
    }

    // Hitung jumlah siswa dan pelanggar
    public function countDash()
    {
        $jmlSiswas = DB::table('siswas')->count();
        $jmlPelanggars = DB::table('pelanggars')->count();

        return [$jmlSiswas, $jmlPelanggars];
    }
}

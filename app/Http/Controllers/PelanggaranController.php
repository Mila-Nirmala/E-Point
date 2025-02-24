<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PelanggaranController extends Controller
{
    
     // Menampilkan daftar pelanggaran dengan fitur pencarian dan pagination.
     
    public function index(): View
    {
        // Mengecek apakah ada pencarian
        if (request('cari')) {
            $pelanggarans = $this->search(request('cari'));
        } else {
            $pelanggarans = Pelanggaran::latest()->paginate(10);
        }

        return view('admin.pelanggaran.index', compact('pelanggarans'));
    }

    
     // Menampilkan form untuk membuat pelanggaran baru.
     
    public function create(): View
    {
        return view('admin.pelanggaran.create');
    }

    
     // Menyimpan data pelanggaran ke database.
     
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'jenis' => 'required|string|max:250',
            'konsekuensi' => 'required|string|max:250',
            'poin' => 'required|integer'
        ]);

        Pelanggaran::create($request->only(['jenis', 'konsekuensi', 'poin']));

        return redirect()->route('pelanggaran.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    
     // Mencari data pelanggaran berdasarkan jenis.
     
    public function search(string $cari)
    {
        return Pelanggaran::whereRaw('LOWER(jenis) LIKE ?', ['%' . strtolower($cari) . '%'])->paginate(10);
    }

    
     // Menampilkan form edit pelanggaran.
     
    public function edit(string $id): View
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        return view('admin.pelanggaran.edit', compact('pelanggaran'));
    }

    
     // Memperbarui data pelanggaran di database
    public function update(Request $request, string $id): RedirectResponse
    {
        // Validasi form
        $validated = $request->validate([
            'jenis' => 'required|string|max:250',
            'konsekuensi' => 'required|string|max:250',
            'poin' => 'required|integer'
        ]);

        // Ambil data berdasarkan ID
        $pelanggaran = Pelanggaran::findOrFail($id);

        // Update data
        $pelanggaran->update($request->only(['jenis', 'konsekuensi', 'poin']));

        // Redirect ke halaman edit dengan pesan sukses
        return redirect()->route('pelanggaran.edit', $id)->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        // get post by id
        $post = Pelanggaran::findOrFail($id);

        //delete post
        $post->delete();

        //redirect to index
        return redirect()->route('pelanggaran.index')->with(['success' => 'Pelanggaran Berhasil Dihapus']);
    }
}

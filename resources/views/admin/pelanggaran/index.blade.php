<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Pelanggaran</title>
</head>
<body>
    <h1>Data Pelanggaran</h1>
    
    <!-- Link ke Dashboard -->
    <a href="{{ route('admin.dashboard') }}">Menu Utama</a><br>

    <!-- Logout -->
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <br><br>

    <!-- Form Pencarian -->
    <form action="" method="get">
        <label>Cari :</label>
        <input type="text" name="cari" value="{{ request('cari') }}">
        <input type="submit" value="Cari">
    </form>

    <br><br>

    <!-- Tombol Tambah Pelanggaran -->
    <a href="{{ route('pelanggaran.create') }}">Tambah Pelanggaran</a>

    <!-- Menampilkan Pesan Sukses -->
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <br>

    <!-- Tabel Data Pelanggaran -->
    <table border="1">
        <thead>
            <tr>
                <th>Jenis</th>
                <th>Konsekuensi</th>
                <th>Poin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pelanggarans as $pelanggaran)
                <tr>
                    <td>{{ $pelanggaran->jenis }}</td>
                    <td>{{ $pelanggaran->konsekuensi }}</td>
                    <td>{{ $pelanggaran->poin }}</td>
                    <td>
                        <!-- Tombol Edit dan Hapus -->
                        <a href="{{ route('pelanggaran.edit', $pelanggaran->id) }}" class="btn btn-sm btn-primary">Edit</a>

                        <form onsubmit="return confirm('Apakah Anda Yakin?');" action="{{ route('pelanggaran.destroy', $pelanggaran->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Data Tidak Ditemukan</td>
                    <td>
                        <a href="{{ route('pelanggaran.index') }}">Kembali</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br>

    <!-- Pagination -->
    {{ $pelanggarans->links() }}

</body>
</html>

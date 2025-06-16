<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggar</title>
</head>
<body>
    <h1>Data Pelanggar</h1>

    <a href="{{ route('admin.dashboard') }}">Menu Utama</a> |
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <br><br>
    <form action="" method="get">
        <label>Cari :</label>
        <input type="text" name="cari" value="{{ request('cari') }}">
        <input type="submit" value="Cari">
    </form>

    <br>
    <form action="{{ route('pelanggar.create') }}" method="GET" style="display: inline;">
        <button type="submit">Tambah Pelanggar</button>
    </form>

    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif

    <br>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Foto</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>No Hp</th>
                <th>Poin</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pelanggars as $pelanggar)
            <tr>
                <td>
                    <img src="{{ asset('storage/public/siswas/'.$pelanggar->image) }}" width="120px" height="120px" alt="Foto Siswa">
                </td>
                <td>{{ $pelanggar->nis }}</td>
                <td>{{ $pelanggar->name }}</td>
                <td>{{ $pelanggar->tingkatan }} {{ $pelanggar->jurusan }} {{ $pelanggar->kelas }}</td>
                <td>{{ $pelanggar->hp }}</td>
                <td>{{ $pelanggar->poin_pelanggar }}</td>
                <td>
                    @if ($pelanggar->status == 0)
                        Tidak Perlu Ditindak
                    @elseif ($pelanggar->status == 1)
                        <form onsubmit="return confirm('Apakah Anda Yakin {{ $pelanggar->name }} Sudah Ditindak?');" action="{{ route('pelanggar.statusTindak', $pelanggar->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit">Perlu Ditindak</button>
                        </form>
                    @elseif ($pelanggar->status == 2)
                        Sudah Ditindak
                    @endif
                </td>
                <td>
                    <form action="{{ route('detailPelanggar.show', $pelanggar->id) }}" method="GET" style="display: inline;">
                        <button type="submit" class="btn btn-sm btn-dark">Detail</button>
                    </form>
                
                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('pelanggar.destroy', $pelanggar->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="margin-left: 5px;">HAPUS</button>
                    </form>
                </td>
            </tr>
            @empty
            <!-- Jika data kosong, tidak tampil di tabel -->
            @endforelse
        </tbody>
    </table>

    @if($pelanggars->isEmpty())
        <div style="margin-top: 15px;">
            <p>Data Tidak Ditemukan</p>
            <a href="{{ route('admin.dashboard') }}">Kembali</a>
        </div>
    @endif

    <br>
    {{ $pelanggars->links() }}
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
</head>
<body>
    <h1>Pilih Data Pelanggar</h1>
    <a href="{{ route('pelanggar.index') }}">Data Pelanggar</a>|
    <a href="{{ route('pelanggar.index') }}">Kembali</a><br><br>

    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>

    <form action="" method="GET">
        <label>Cari:</label>
        <input type="text" name="cari" value="{{ request('cari') }}">
        <input type="submit" value="Cari">
    </form>

    <br><br>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Foto</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Kelas</th>
                <th>No Hp</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($siswas as $siswa)
            <tr>
                <td>
                    @if($siswa->image)
                        <img src="{{ asset('storage/public/siswas/'.$siswa->image) }}" width="120" height="120" alt="Foto Siswa">
                    @else
                        <p>Tidak ada foto</p>
                    @endif
                </td>
                <td>{{ $siswa->nis }}</td>
                <td>{{ $siswa->name }}</td>
                <td>{{ $siswa->email }}</td>
                <td>{{ $siswa->tingkatan }} {{ $siswa->jurusan }} {{ $siswa->kelas }}</td>
                <td>{{ $siswa->hp }}</td>
                <td>
                    <form action="{{ route('pelanggar.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_siswa" value="{{ $siswa->id }}">
                        <button type="submit">Tambah Pelanggaran</button>
                    </form>
                </td>
            </tr>
            @empty
                {{-- Tidak menampilkan baris kosong di tabel --}}
            @endforelse
        </tbody>
    </table>

    @if($siswas->isEmpty())
        <div style="margin-top: 15px;">
            <p>Data Tidak Ditemukan. Silahkan cek pada Data Pelanggar</p>
        </div>
    @endif

    <br>

    <!-- Pagination -->
    {{ $siswas->links() }}

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Pelanggar</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 20px 0;
            width: 100%;
        }
        th, td {
            border: 1px solid;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Detail Pelanggar</h1>
    

    <table>
        <tr>
            <td colspan="4" style="text-align: center;">
                <img src="{{ asset('storage/public/siswas/'.$pelanggar->image) }}" width="120px" height="120px" alt="Foto Pelanggar">
            </td>
        </tr>
        <tr>
            <th colspan="2">Akun Pelanggar</th>
            <th colspan="2">Data Pelanggar</th>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $pelanggar->name }}</td>
            <th>NIS</th>
            <td> {{ $pelanggar->nis }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td> {{ $pelanggar->email }}</td>
            <th>Kelas</th>
            <td> {{ $pelanggar->tingkatan }} {{ $pelanggar->jurusan }} {{ $pelanggar->kelas }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <th>No HP</th>
            <td> {{ $pelanggar->hp }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <th>Status</th>
            <td> {{ $pelanggar->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
        </tr>
    </table>

    <br><br>
    <h1>Pilih Pelanggaran</h1>

    <form action="" method="GET">
        <label>Cari :</label>
        <input type="text" name="cari" value="{{ request('cari') }}">
        <input type="submit" value="Cari">
    </form>

    <br>
    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif

    <table>
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
                    <form action="{{ route('pelanggar.storePelanggaran', $pelanggaran->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_pelanggar" value="{{ $pelanggar->id }}">
                        <input type="hidden" name="id_user" value="{{ $idUser }}">
                        <input type="hidden" name="id_pelanggaran" value="{{ $pelanggaran->id }}">
                        <button type="submit">Tambah Pelanggaran</button>
                    </form>
                </td>
            </tr>
            @empty
        {{-- Tidak menampilkan baris kosong di tabel --}}
        @endforelse
        </tbody>
    </table>

    @if($pelanggarans->isEmpty())
    <div style="margin-top: 15px;">
        <p>Data Tidak Ditemukan !</p>
        <form action="{{ route('pelanggar.index') }}" method="GET" style="display: inline-block;">
            <button type="submit">Kembali</button>
        </form>
    </div>
    @endif
    <form action="{{ route('pelanggar.index') }}" method="GET" style="display: inline-block;">
        <button type="submit">Kembali</button>
    </form>

<br>

    <div>
        {{ $pelanggarans->links() }}
    </div>
</body>
</html>

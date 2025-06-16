<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <a class="nav-link" href="{{ route('siswa.index') }}">Data Siswa</a>
    <a class="nav-link" href="{{ route('akun.index') }}">Data Akun</a>
    <a class="nav-link" href="{{ route('pelanggaran.index') }}">Data Pelanggaran</a>
    <a class="nav-link" href="{{ route('pelanggar.index') }}">Data Pelanggar</a>
    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
    <form action="{{ route('logout') }}" id="logout-form" method="POST">
        @csrf 
    </form>
    <h1>Dashboard Admin</h1>
    @if($message = Session::get('success'))
    <p>{{$message}}</p>
    @else
    <p>Kamu Telah Login</p>
    @endif


    <h3>Jumlah Siswa {{ $jmlSiswas }}</h3>
    <h3>Jumlah Pelanggar {{ $jmlPelanggars }}</h3>
    <br><br><br>

    <h1>Top 10 Siswa dengan POIN PELANGGARAN TERTINGGI</h1><br>
    <table class="tabel" border="1">
        <tr>
            <th>Foto</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>No HP</th>
            <th>Poin</th>
            <th>Aksi</th>
        </tr>
        @forelse ($pelanggars as $pelanggar)
        <tr>
            <td>
                <img src="{{ asset('storage/public/siswas/'.$pelanggar->image) }}" width="120px" height="120px" alt="">
            </td>
            <td>{{ $pelanggar->nis }}</td>
            <td>{{ $pelanggar->name }}</td>
            <td>{{ $pelanggar->tingkatan }} {{ $pelanggar->jurusan }} {{ $pelanggar->kelas }}</td>
            <td>{{ $pelanggar->hp }}</td>
            <td>{{ $pelanggar->poin_pelanggar }}</td>
            <td>
                <a href="{{ route('pelanggar.show', $pelanggar->id) }}" class="btn btn-sm btn-dark">Detail Pelanggaran</a>
            </td>
        </tr>
        @empty
        <tr>
            <td>
                <p>Data Tidak Ditemukan!</p>
            </td>
            <td>
                <a href="{{ route('pelanggar.index') }}">Kembali</a>
            </td>
        </tr>
        @endforelse

</table>

    <br><br><br>

        <h1>Top 10 PELANGGARAN YANG SERING DILAKUKAN</h1><br>
        <table class="tabel" border="1">
            <tr>
                <th>Nama pelanggaran</th>
                <th>Konsekuensi</th>
                <th>Poin</th>
                <th>Total Pelanggaran</th>
            </tr>
            @forelse ($hitung as $hit)
            <tr>
                <td>{{ $hit->jenis }}</td>
                <td>{{ $hit->konsekuensi }}</td>
                <td>{{ $hit->poin }}</td>
                <td>{{ $hit->totals }}</td>
            </tr>
            @empty
            <tr>
                <td>
                    <p>Data Tidak Ditemukan!</p>
                </td>
            </tr>
            @endforelse
        </table>
</body>
</html>
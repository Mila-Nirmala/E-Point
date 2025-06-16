<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Detail Pelanggaran</title>
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
    <h1>Data Pelanggar</h1>
    

    <table>
        <tr>
            <td colspan="4" style="text-align: center;">
                <img src="{{ asset('storage/public/siswas/'.$pelanggar->image) }}" width="120" height="120" alt="Foto">
            </td>
        </tr>
        <tr>
            <th colspan="2">Akun Pelanggar</th>
            <th colspan="2">Data Pelanggar</th>
        </tr>
        <tr>
            <th>Nama </th>
            <td> {{ $pelanggar->name }}</td>
            <th>NIS </th>
            <td> {{ $pelanggar->nis }}</td>
        </tr>
        <tr>
            <th>Email </th>
            <td> {{ $pelanggar->email }}</td>
            <th>Kelas </th>
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
            <td>
                @if($pelanggar->status == 0)
                    Tidak Perlu Ditindak!
                @elseif($pelanggar->status == 1)
                    Perlu Ditindak
                @else
                    Sudah Ditindak
                @endif
            </td>
        </tr>
        <tr>
            <td>Total Poin</td>
            <td colspan="3"> <span style="font-size: 24px;"><strong>{{ $pelanggar->poin_pelanggar }}</strong></span></td>
        </tr>
    </table>

    <br><br>
    <h1>Pelanggaran Yang Dilakukan</h1>
    <br>

    @if (Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif

    <a href="{{ route('pelanggar.show', $pelanggar->id) }}">
        <button>Tambah Pelanggaran</button>
    </a>
    

    <table class="tabel">
        <thead>
            <tr>
                <th>Nama PTK</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Konsekuensi</th>
                <th>Poin</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($details as $detail)
        <tr>
            <td>{{ $detail->name }}</td>
            <td>{{ $detail->created_at }}</td>
            <td>{{ $detail->jenis }}</td>
            <td>{{ $detail->konsekuensi }}</td>
            <td>{{ $detail->poin }}</td>
            <td>
                @if($detail->status == 0)
                <form onsubmit="return confirm('Apakah {{ $pelanggar->name }} sudah diberikan sanksi?');" action="{{ route('detailPelanggar.update', $detail->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_pelanggar" value="{{ $detail->id_pelanggar }}">
                    <button type="submit">Belum Diberikan Sanksi!</button>
                </form>
                @else
                Sudah Diberikan Sanksi
                @endif
            </td>
            <td>
                <form onsubmit="return confirm('Apakah Anda yakin ingin menghapus?')" action="{{ route('detailPelanggar.destroy', $detail->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id_pelanggar" value="{{ $detail->id_pelanggar }}">
                    <input type="hidden" name="poin_pelanggaran" value="{{ $detail->poin }}">
                    <button type="submit">Hapus Pelanggaran</button>
                </form>
            </td>
        </tr>
        @empty
        {{-- Tidak menampilkan baris kosong di tabel --}}
        @endforelse
        </tbody>
    </table>

    @if($details->isEmpty())
    <div style="margin-top: 15px;">
        <p>Data Tidak Ditemukan. Silahkan Tambah Pelanggaran !</p>
        
    </div>
   @endif
   <form action="{{ route('pelanggar.index') }}" method="GET" style="display: inline;">
        <button type="submit">Kembali</button>
   </form>
<br>

    <div>
        {{ $details->links() }}
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa</title>
</head>
<body>
    <h1>Tambah Siswa</h1>
    <br>
    <a href="{{ route('siswa.index') }}">Kembali</a>
    <br>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h2>Akun Siswa</h2>
    <label for="name">Nama Lengkap</label>
    <input type="text" name="name" id="name" value="{{ old('name') }}">
    <br><br>
    <label for="email">Email Address</label>
    <input type="email" name="email" id="email" value="{{ old('email') }}">
    <br><br>
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <br><br>

    <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    <br><br>

    <h2>Data Siswa</h2>
    <label for="image">Foto Siswa</label>
    <input type="file" name="image" id="image" accept="image/*" required>
    <br><br>

    <label for="nis">Nis Siswa</label>
    <input type="text" name="nis" id="nis" value="{{ old('nis') }}" required>
    <br><br>

    <label for="tingkatan">Tingkatan</label>
    <select name="tingkatan" id="tingkatan" required>
        <option value="">Pilih Tingkatan</option>
        <option value="X">X</option>
        <option value="XI">XI</option>
        <option value="XII">XII</option>
    </select>
    <br><br>
    <label for="jurusan">Jurusan</label>
    <select name="jurusan" id="jurusan" required>
        <option value="">Pilih Jurusan</option>
        <option value="TBSM">TBSM</option>
        <option value="TJKT">TJKT</option>
        <option value="PPLG">PPLG</option>
        <option value="DKV">DKV</option>
        <option value="TOI">TOI</option>
    </select>
    <br><br>
    
    <label for="kelas">Kelas</label>
    <select name="kelas" id="kelas" required>
        <option value="">Pilih Kelas</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>
    <br><br>

    <label for="hp">No Hp</label>
    <input type="text" name="hp" id="hp" value="{{ old('hp') }}" required>
    <br><br>

    <button type="submit">SIMPAN DATA</button>
    <button type="reset">RESET DATA</button>
    </form>
</body>
</html>

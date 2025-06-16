<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Akun</title>
    <style type="text/css">
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0px;
        }

        table, th, td {
            border: 1px solid;
        }
    </style>
</head>
<body>
    <h1>Edit Akun</h1>
    <a href="{{ route('akun.index') }}">Kembali</a><br><br>

    <!-- Menampilkan pesan error jika ada -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Menampilkan pesan sukses -->
    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif

    <!-- Form Update Data Akun -->
    <form action="{{ route('akun.update', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <h2>Data Akun</h2>
        
        <label for="name">Nama Lengkap</label><br>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        <br><br>

        <label for="usertype">Hak Akses</label><br>
        <select name="usertype" id="usertype" required>
            <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="ptk" {{ $user->usertype == 'ptk' ? 'selected' : '' }}>PTK</option>
            <option value="Siswa" {{ $user->usertype == 'Siswa' ? 'selected' : '' }}>Siswa</option>
        </select>
        <br><br>

        
    </form>

    <!-- Form Update Email -->
    <form action="{{ route('akun.updateEmail', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Email Address</label><br>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        <br><br>

        
       
    </form>

    <!-- Form Update Password -->
    <form action="{{ route('akun.updatePassword', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Password</label><br>
        <input type="password" id="password" name="password" required>
        <br><br>

        <label>Confirm Password</label><br>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        <br><br>

        <button type="submit">Simpan Perubahan</button><br><br>
        <br><br>
    </form>

</body>
</html>

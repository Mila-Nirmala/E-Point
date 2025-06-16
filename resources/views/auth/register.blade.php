@extends ('auth.layouts')

@section ('content')
<h1>Daftar</h1>
<br>
<a href="{{ route('login') }}">Login</a>
<br>

<form action="{{ route('register.store') }}" method="post">
    @csrf
    <label>Nama Lengkap</label>
    <input type="text" name="name" id="name" value="{{ old('name') }}">
    @if ($errors->first('name'))
    <span class="text-danger">{{ $errors->first('name') }}</span>
    @endif
    <br>

    <label>Email Address</label>
    <input type="email" name="email" id="email" value="{{ old('email') }}">
    @if ($errors->first('email'))
    <span class="text-danger">{{ $errors->first('email') }}</span>
    @endif
    <br>

    <label>Password</label>
    <input type="password" name="password" id="password">
    @if ($errors->first('password'))
    <span class="text-danger">{{ $errors->first('password') }}</span>
    @endif
    <br>

    <label for="password_confirmation">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation">
    <br>

    <label>Role</label>
    <select name="usertype" id="usertype">
        <option value="siswa" {{ old('usertype') == 'siswa' ? 'selected' : '' }}>Siswa</option>
        <option value="ptk" {{ old('usertype') == 'ptk' ? 'selected' : '' }}>PTK</option>
        <option value="admin" {{ old('usertype') == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
    @if ($errors->first('role'))
    <span class="text-danger">{{ $errors->first('usertype') }}</span>
    @endif
    <br>

    <input type="submit" value="Register">
</form>
@endsection

@extends ('auth.layouts')
@section('content')

<style>
    body {
        background-color: #a37777;
        font-family: Arial, sans-serif;
    }

    .login-box {
        width: 400px;
        margin: 80px auto;
        background-color: #2e2e2e;
        padding: 30px;
        border-radius: 10px;
        color: #fff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
    }

    .login-box h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .login-box label {
        display: block;
        margin-top: 15px;
    }

    .login-box input[type="email"],
    .login-box input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: none;
        border-radius: 5px;
    }

    .login-box input[type="submit"] {
        background-color: #e57b77;
        color: #fff;
        cursor: pointer;
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        margin-top: 20px;
    }

    .login-box a {
        color: #ddd;
        display: block;
        margin-top: 15px;
        text-align: center;
    }

    .login-box img {
        display: block;
        margin: 0 auto 15px;
        width: 100px;
    }
</style>

<div class="login-box">
    {{-- Logo --}}
    <img src="{{ asset('storage/logo/Logo-Sekolah.png') }}" alt="Logo Sekolah">




    <h1>Login</h1>

    <form action="{{ route('authenticate') }}" method="post">
        @csrf

        <label>Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

        <label>Password</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Login">
    </form>

    <a href="{{ route('register') }}">Don’t have account ? Register Now</a>
</div>

@endsection

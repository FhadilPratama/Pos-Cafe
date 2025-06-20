@extends('layouts.auth')

@section('content')
    <h2>Login To Vintage Cafe</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <input type="email" name="email" placeholder="Email" class="form-input" required autofocus>
        </div>

        <div class="form-group">
            <input type="password" name="password" placeholder="Password" class="form-input" required>
        </div>

        <button type="submit" class="submit-button">Login</button>
    </form>
@endsection

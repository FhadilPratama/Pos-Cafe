@extends('layouts.app')

@section('content')
<div class="user-form">
    <h2>Tambah User Baru</h2>

    <a href="{{ route('users.index') }}" class="back-button">← Kembali</a>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-input" value="{{ old('name') }}" required>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-input" required>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required>
            @error('password_confirmation')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-input" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
            </select>
            @error('role')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="submit-button">Simpan</button>
        </div>
    </form>
</div>
@endsection

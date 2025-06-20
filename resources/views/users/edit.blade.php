@extends('layouts.app')

@section('content')
<div class="user-form">
    <h2>Edit User</h2>

    <a href="{{ route('users.index') }}" class="back-button">← Kembali</a>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-input" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-input" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="owner" {{ old('role', $user->role) == 'owner' ? 'selected' : '' }}>Owner</option>
                <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
            </select>
            @error('role')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <hr style="margin: 25px 0; border-color: #DEB887;">

        <p style="font-style: italic; color: #6B4226;">Kosongkan jika tidak ingin mengubah password</p>

        <div class="form-group">
            <label for="password">Password Baru</label>
            <input type="password" name="password" id="password" class="form-input">
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
            @error('password_confirmation')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="submit-button">Perbarui</button>
        </div>
    </form>
</div>
@endsection

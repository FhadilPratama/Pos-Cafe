@extends('layouts.app')

@section('content')
<div class="main">
    <div class="user-form">
        <h2>Tambah Menu</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('menus.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="price" value="{{ old('price') }}" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="category" class="form-input" required>
                    <option value="">-- Pilih --</option>
                    <option value="makanan" {{ old('category') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ old('category') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                </select>
            </div>

            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="image" class="form-input">
            </div>

            <button type="submit" class="btn btn-add submit-button">Simpan</button>
        </form>

        <a href="{{ route('menus.index') }}" class="back-button">Kembali</a>
    </div>
</div>
@endsection

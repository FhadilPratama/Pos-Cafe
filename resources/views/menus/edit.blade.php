@extends('layouts.app')

@section('content')
<div class="main">
    <div class="user-form">
        <h2>Edit Menu</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('menus.update', $menu->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name', $menu->name) }}" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="price" value="{{ old('price', $menu->price) }}" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="category" class="form-input" required>
                    <option value="makanan" {{ $menu->category == 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ $menu->category == 'minuman' ? 'selected' : '' }}>Minuman</option>
                </select>
            </div>

            <div class="form-group">
                <label>Gambar</label><br>
                @if($menu->image)
                    <img src="{{ asset($menu->image) }}" width="100" alt="Gambar Menu" style="border-radius: 8px; margin-bottom: 10px;">
                @endif
                <input type="file" name="image" class="form-input">
            </div>

            <button type="submit" class="btn btn-edit submit-button">Update</button>
        </form>

        <a href="{{ route('menus.index') }}" class="back-button">Kembali</a>
    </div>
</div>
@endsection

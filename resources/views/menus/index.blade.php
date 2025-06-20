@extends('layouts.app')

@section('content')
    <div class="main">
        <h1 class="activity-list h2">Daftar Menu</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('menus.create') }}" class="btn btn-add">+ Tambah Menu</a>

        <form method="GET" action="{{ route('menus.index') }}"
            style="margin: 20px 0; display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">
            <!-- Baris 1: Kategori & Harga -->
            <label for="category">Filter Kategori:</label>
            <select name="category" id="category" onchange="this.form.submit()" class="form-input" style="width: 150px;">
                <option value="" {{ !$category ? 'selected' : '' }}>Semua</option>
                <option value="makanan" {{ $category == 'makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="minuman" {{ $category == 'minuman' ? 'selected' : '' }}>Minuman</option>
            </select>

            <label for="min_price">Harga Minimal (Rp):</label>
            <input type="number" name="min_price" id="min_price" value="{{ $min_price ?? '' }}" class="form-input"
                style="width: 120px;" placeholder="0" onchange="this.form.submit()">

            <label for="max_price">Harga Maksimal (Rp):</label>
            <input type="number" name="max_price" id="max_price" value="{{ $max_price ?? '' }}" class="form-input"
                style="width: 120px;" placeholder="999999" onchange="this.form.submit()">

            <!-- Spacer untuk baris baru -->
            <div style="flex-basis: 100%; height: 0;"></div>

            <!-- Baris 2: Cari Nama dan tombol -->
            <label for="search" style="min-width: auto;">Cari Nama:</label>
            <input type="text" name="search" id="search" value="{{ $search ?? '' }}" class="form-input"
                placeholder="Cari menu..." onkeypress="if(event.key === 'Enter') this.form.submit()" style="width: 200px;">

            <button type="submit" class="submit-button" style="padding: 8px 16px;">Cari</button>
        </form>


        <table class="table-users">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                    <tr>
                        <td>{{ $menu->name }}</td>
                        <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($menu->category) }}</td>
                        <td>
                            @if($menu->image)
                                <img src="{{ asset($menu->image) }}" width="80" alt="Gambar Menu" style="border-radius: 8px;">
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-edit">Edit</a>
                            <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete"
                                    onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada menu yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
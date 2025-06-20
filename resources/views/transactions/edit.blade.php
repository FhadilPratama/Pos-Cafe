@extends('layouts.app')

@section('content')
<div class="main">
    <h2>Edit Transaksi</h2>

    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" class="user-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="customer_name">Nama Customer</label>
            <input type="text" name="customer_name" id="customer_name" class="form-input" value="{{ old('customer_name', $transaction->customer_name) }}" required>
            @error('customer_name')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="product_name">Nama Produk</label>
            <input type="text" name="product_name" id="product_name" class="form-input" value="{{ old('product_name', $transaction->product_name) }}" required>
            @error('product_name')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="quantity">Jumlah</label>
            <input type="number" name="quantity" id="quantity" class="form-input" min="1" value="{{ old('quantity', $transaction->quantity) }}" required>
            @error('quantity')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Harga (per unit)</label>
            <input type="number" step="0.01" name="price" id="price" class="form-input" min="0" value="{{ old('price', $transaction->price) }}" required>
            @error('price')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-input" required>
                <option value="pending" {{ old('status', $transaction->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ old('status', $transaction->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ old('status', $transaction->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="submit-button">Update</button>
        <a href="{{ route('transactions.index') }}" class="back-button">Kembali</a>
    </form>
</div>
@endsection

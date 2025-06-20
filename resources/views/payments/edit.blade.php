@extends('layouts.app')

@section('content')
<h2>Edit Pembayaran #{{ $payment->id }}</h2>

<a href="{{ route('payments.index') }}" class="btn btn-secondary" style="margin-bottom: 15px;">Kembali ke Daftar Pembayaran</a>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('payments.update', $payment) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="transaction_id">Transaksi</label>
        <select name="transaction_id" id="transaction_id" class="form-control" required>
            @foreach($transactions as $transaction)
                <option value="{{ $transaction->id }}" {{ $payment->transaction_id == $transaction->id ? 'selected' : '' }}>
                    #{{ $transaction->id }} - {{ $transaction->customer_name }} (Total: Rp {{ number_format($transaction->total, 2, ',', '.') }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="jumlah_bayar">Jumlah Bayar (Rp)</label>
        <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" step="0.01" min="0" value="{{ old('jumlah_bayar', $payment->jumlah_bayar) }}" required>
    </div>

    <div class="form-group">
        <label for="payment_method">Metode Pembayaran</label>
        <input type="text" name="payment_method" id="payment_method" class="form-control" value="{{ old('payment_method', $payment->payment_method) }}" placeholder="Misal: Cash, Debit, E-wallet">
    </div>

    <button type="submit" class="btn btn-primary">Update Pembayaran</button>
</form>

@endsection

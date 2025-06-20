@extends('layouts.app')

@section('content')
    <div class="main transaction-detail">
        <h2 class="page-title">Detail Transaksi</h2>

        <a href="{{ route('transactions.index') }}" class="btn back-button btn-back">Kembali ke Daftar</a>

        <div class="card transaction-card" style="margin-top: 20px;">
            <p><strong>Customer:</strong> {{ $transaction->customer_name }}</p>
            <p><strong>Status:</strong> <span class="status {{ $transaction->status }}">{{ ucfirst($transaction->status) }}</span></p>
            <p><strong>Total Item:</strong> {{ $transaction->quantity }}</p>
            <p><strong>Total Harga:</strong> Rp {{ number_format($transaction->total, 2, ',', '.') }}</p>
        </div>

        <h3 class="section-title" style="margin-top: 30px;">Detail Menu</h3>
        <table class="table-users transaction-table">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Qty</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                    <tr>
                        <td>{{ $detail->menu->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>Rp {{ number_format($detail->price, 2, ',', '.') }}</td>
                        <td>Rp {{ number_format($detail->subtotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

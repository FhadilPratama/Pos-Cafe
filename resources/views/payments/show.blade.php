@extends('layouts.app')

@section('content')
<div class="user-form">
    <h2>Detail Pembayaran #{{ $payment->id }}</h2>

    <a href="{{ route('payments.index') }}" class="back-button">← Kembali ke Daftar</a>

    <table class="table-users" style="max-width: 100%; margin-top: 20px;">
        <tr>
            <th>Transaksi</th>
            <td>
                {{ $payment->transaction->customer_name }}<br>
                Status: <strong>{{ ucfirst($payment->transaction->status) }}</strong><br>
                Total: Rp {{ number_format($payment->transaction->total, 2, ',', '.') }}
            </td>
        </tr>
        <tr>
            <th>Jumlah Bayar</th>
            <td>Rp {{ number_format($payment->jumlah_bayar, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Kembalian</th>
            <td>Rp {{ number_format($payment->kembalian, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Metode Pembayaran</th>
            <td>{{ $payment->payment_method ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal Bayar</th>
            <td>{{ $payment->payment_date ? $payment->payment_date->format('d M Y H:i') : '-' }}</td>
        </tr>
        <tr>
            <th>Dibuat pada</th>
            <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
        </tr>
    </table>
</div>
@endsection

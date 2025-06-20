@extends('layouts.app')

@section('content')
    <div class="activity-list">
        <h2>Daftar Pembayaran</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table-users">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Transaksi</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->transaction->customer_name }}</td>
                        <td>Rp {{ number_format($payment->transaction->total, 2, ',', '.') }}</td> {{-- ✅ Tambahan --}}
                        <td>{{ $payment->payment_method ?? '-' }}</td>
                        <td>{{ $payment->payment_date ? $payment->payment_date->format('d M Y H:i') : '-' }}</td>
                        <td>
                            <a href="{{ route('payments.show', $payment) }}" class="btn btn-edit btn-sm">Lihat</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;">Belum ada data pembayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-wrapper">
            {{ $payments->appends(request()->only('search', 'status', 'date'))->links('vendor.pagination.custom-simple') }}
        </div>
    </div>
@endsection
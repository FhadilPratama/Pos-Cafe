@extends('layouts.app')

@section('content')
    <div class="main">
        <h2 class="page-title">Daftar Transaksi</h2>

        <a href="{{ route('transactions.create') }}" class="btn btn-add">Tambah Transaksi</a>

        {{-- Form Search + Filter Status --}}
        <form action="{{ route('transactions.index') }}" method="GET">
            <input type="text" name="search" class="form-input" placeholder="Cari nama customer..."
                value="{{ request('search') }}">

            <select name="status" class="form-input">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
            </select>

            <input type="date" name="date" class="form-input" value="{{ request('date') }}">

            <button type="submit" class="submit-button">Filter</button>

            @if(request()->hasAny(['search', 'status', 'date']))
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table-users">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Customer</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal & Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $index => $transaction)
                    <tr>
                        <td>{{ $transactions->firstItem() + $index }}</td>
                        <td>{{ $transaction->customer_name }}</td>
                        <td>{{ $transaction->quantity }}</td>
                        <td>Rp {{ number_format($transaction->total, 2, ',', '.') }}</td>
                        <td>{{ ucfirst($transaction->status) }}</td>
                        <td>{{ $transaction->created_at->format('d-m-Y H:i:s') }}</td>
                        <td class="table-actions">
                            <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-edit btn-sm">Lihat</a>
                            @if ($transaction->status === 'pending')
                               <a href="{{ route('payments.create', ['transaction_id' => $transaction->id]) }}" class="btn btn-edit btn-sm">Bayar</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-wrapper">
            {{ $transactions->appends(request()->only('search', 'status', 'date'))->links('vendor.pagination.custom-simple') }}
        </div>
    </div>
@endsection
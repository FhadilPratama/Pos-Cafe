@extends('layouts.app')

@section('content')
<div class="activity-list">
    <h2>Laporan Pendapatan</h2>

    <form method="GET" action="{{ route('laporan.index') }}">
        <label for="tanggal_mulai">Dari:</label>
        <input type="date" name="tanggal_mulai" class="form-input" value="{{ request('tanggal_mulai') }}">

        <label for="tanggal_selesai">Sampai:</label>
        <input type="date" name="tanggal_selesai" class="form-input" value="{{ request('tanggal_selesai') }}">

        <button type="submit" class="submit-button">Filter</button>
    </form>

    <div style="margin-top: 15px; margin-bottom: 15px;">
        <a href="{{ route('laporan.exportExcel', request()->all()) }}" class="btn btn-add">Export Excel</a>
        <a href="{{ route('laporan.exportPDF', request()->all()) }}" class="btn btn-delete" target="_blank">Export PDF</a>
    </div>

    <form action="{{ route('laporan.importExcel') }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 20px;">
        @csrf
        <input type="file" name="file" required class="form-input" style="display: inline-block; width: auto; margin-right: 10px;">
        <button type="submit" class="btn btn-edit">Import Excel</button>
    </form>

    <table class="table-users" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $totalSeluruh = 0;
                $no = 1;
            @endphp
            @forelse($laporan->flatten() as $payment)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $payment->transaction->customer_name }}</td>
                    <td>Rp {{ number_format($payment->transaction->total, 0, ',', '.') }}</td>
                    <td><small>{{ $payment->payment_date->format('d M Y H:i') }}</small></td>
                </tr>
                @php $totalSeluruh += $payment->jumlah_bayar; @endphp
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data pembayaran.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Total Keseluruhan</strong></td>
                <td colspan="2"><strong>Rp {{ number_format($totalSeluruh, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="user-form">
        <h2>Tambah Pembayaran Baru</h2>

        <a href="{{ route('payments.index') }}" class="back-button">← Kembali ke Daftar</a>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($selectedTransaction))
            <p>
                <strong>Transaksi:</strong> #{{ $selectedTransaction->id }} - {{ $selectedTransaction->customer_name }} <br>
                <strong>Total:</strong> Rp {{ number_format($selectedTransaction->total, 2, ',', '.') }}
            </p>

            <form action="{{ route('payments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="transaction_id" value="{{ $selectedTransaction->id }}">

                <div class="form-group">
                    <label for="jumlah_bayar">Jumlah Bayar (Rp)</label>
                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-input" step="0.01" min="0"
                        value="{{ old('jumlah_bayar') }}" required>
                </div>

                <div class="form-group">
                    <label for="kembalian">Kembalian (Rp)</label>
                    <input type="text" id="kembalian" class="form-input" readonly>
                </div>


                <div class="form-group">
                    <label for="payment_method">Metode Pembayaran</label>
                    <input type="text" name="payment_method" id="payment_method" class="form-input"
                        value="{{ old('payment_method') }}" placeholder="Misal: Cash, Debit, E-wallet">
                </div>

                <button type="submit" class="submit-button">Simpan Pembayaran</button>
            </form>
        @else
            <p>Transaksi tidak ditemukan atau belum dipilih.</p>
            <a href="{{ route('payments.index') }}">Kembali ke daftar pembayaran</a>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jumlahBayarInput = document.getElementById('jumlah_bayar');
            const kembalianInput = document.getElementById('kembalian');
            const totalTransaksi = {{ $selectedTransaction->total ?? 0 }};

            function hitungKembalian() {
                const jumlahBayar = parseFloat(jumlahBayarInput.value) || 0;
                const kembalian = jumlahBayar - totalTransaksi;
                kembalianInput.value = kembalian > 0 ? 'Rp ' + kembalian.toLocaleString('id-ID', { minimumFractionDigits: 2 }) : 'Rp 0,00';
            }

            jumlahBayarInput.addEventListener('input', hitungKembalian);
        });
    </script>

@endsection
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Café POS</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="wrapper">
        {{-- Sidebar --}}
        <div class="sidebar">
            <div class="sidebar-header">
                <h1>Café POS</h1>
            </div>
            <nav>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('menus.index') }}">Menu</a> {{-- Semua role bisa akses menu --}}

                @auth
                    @if(auth()->user()->role === 'owner')
                        {{-- Owner bisa akses semua --}}
                        <a href="{{ route('laporan.index') }}">Report</a>
                        @elseif(auth()->user()->role === 'admin')
                        {{-- Admin akses sebagian --}}
                        <a href="{{ route('transactions.index') }}">Transaksi</a>
                        <a href="{{ route('payments.index') }}">Payments</a>
                        <a href="{{ route('laporan.index') }}">Report</a>
                        <a href="{{ route('users.index') }}">User Management</a>
                    @elseif(auth()->user()->role === 'kasir')
                        {{-- Kasir hanya akses transaksi dan pembayaran --}}
                        <a href="{{ route('transactions.index') }}">Transaksi</a>
                        <a href="{{ route('payments.index') }}">Payments</a>
                    @endif
                @endauth
            </nav>

        </div>

        {{-- Main Content --}}
        <div class="main">
            @include('layouts.header')

            <main>
                @yield('content')
            </main>

            @include('layouts.footer')
        </div>
    </div>

    @yield('scripts')
</body>

</html>
@extends('layouts.app')

@section('content')
    <div style="display: flex; gap: 30px; flex-wrap: wrap;">

        {{-- Keranjang --}}
        <div style="flex: 1; min-width: 300px;">
            <div class="activity-list">
                <h2>Keranjang</h2>
                <ul id="cart-list" style="list-style: none; padding-left: 0;"></ul>
                <p style="font-weight: bold; margin-top: 10px;">
                    Total: Rp <span id="total-price">0</span>
                </p>
                <form id="transaction-form" action="{{ route('transactions.store') }}" method="POST"
                    onsubmit="return prepareCartData()">
                    @csrf

                    <div style="margin-bottom: 10px;">
                        <label for="customer_name">Nama Customer:</label>
                        <input type="text" name="customer_name" id="customer_name" placeholder="Contoh: Budi"
                            style="width: 100%; padding: 5px;">
                    </div>
                    <input type="hidden" name="status" value="pending">


                    <input type="hidden" name="items" id="cart-items">

                    <button type="submit" class="submit-button" style="margin-top: 20px;">Simpan Transaksi</button>
                </form>

            </div>
        </div>

        {{-- Daftar Menu --}}
        <div class="stats-row">
            @foreach($menus as $menu)
                <div class="card-menu">
                    <img src="{{ asset($menu->image) }}" alt="{{ $menu->name }}" class="menu-img">
                    <h3 class="menu-title">{{ $menu->name }}</h3>
                    <p class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                    <div class="menu-actions">
                        <button type="button" class="btn btn-edit" id="btn-minus-{{ $menu->id }}"
                            onclick="updateCart({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ $menu->price }}, -1)"
                            disabled>-</button>
                        <span id="qty-{{ $menu->id }}">0</span>
                        <button type="button" class="btn btn-add"
                            onclick="updateCart({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ $menu->price }}, 1)">+</button>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        let cart = {};

        function updateCart(id, name, price, change) {
            if (!cart[id]) {
                cart[id] = { name, price, qty: 0 };
            }

            cart[id].qty += change;

            if (cart[id].qty <= 0) {
                delete cart[id];
                document.getElementById('qty-' + id).innerText = 0;
                document.getElementById('btn-minus-' + id).disabled = true;
            } else {
                document.getElementById('qty-' + id).innerText = cart[id].qty;
                document.getElementById('btn-minus-' + id).disabled = false;
            }

            updateDisplay();
        }

        function updateDisplay() {
            const list = document.getElementById('cart-list');
            const total = document.getElementById('total-price');
            const itemsInput = document.getElementById('cart-items');
            let html = '';
            let totalPrice = 0;
            let items = [];

            for (const id in cart) {
                const item = cart[id];
                html += `<li style="display:flex; justify-content: space-between; padding: 4px 0;">
                                            <span>${item.name}</span>
                                            <span>x ${item.qty}</span>
                                        </li>`;
                totalPrice += item.price * item.qty;
                items.push({ id: parseInt(id), qty: item.qty });
            }

            list.innerHTML = html || '<li><em>Belum ada item</em></li>';
            total.innerText = totalPrice.toLocaleString('id-ID');
            itemsInput.value = JSON.stringify(items);
        }

        function prepareCartData() {
            updateDisplay();
            const itemsInput = document.getElementById('cart-items');
            if (!itemsInput.value || itemsInput.value === '[]') {
                alert('Keranjang masih kosong. Silakan pilih menu.');
                return false;
            }
            return true;
        }
    </script>
@endsection
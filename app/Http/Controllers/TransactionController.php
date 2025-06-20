<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::orderBy('created_at', 'asc');

        if ($request->filled('search')) {
            $query->where('customer_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $transactions = $query->paginate(10);
        $transactions->appends($request->only('search', 'status', 'date'));

        return view('transactions.index', compact('transactions'));
    }






    public function create()
    {
        $menus = Menu::all();
        $transactions = Transaction::all();
        return view('transactions.create', compact('menus', 'transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|json',
            'customer_name' => 'nullable|string|max:255',
            'status' => 'nullable|string',
        ]);

        $items = json_decode($request->items, true);

        if (empty($items)) {
            return back()->withErrors(['items' => 'Keranjang tidak boleh kosong'])->withInput();
        }

        DB::beginTransaction();

        try {
            $total = 0;

            // Untuk menghindari multiple query Menu::findOrFail,
            // kita bisa ambil semua menu dalam satu query
            $menuIds = collect($items)->pluck('id')->all();
            $menus = Menu::whereIn('id', $menuIds)->get()->keyBy('id');

            foreach ($items as $item) {
                if (!isset($menus[$item['id']])) {
                    throw new \Exception("Menu dengan ID {$item['id']} tidak ditemukan.");
                }
                $menu = $menus[$item['id']];
                $total += $menu->price * $item['qty'];
            }

            $totalQuantity = array_sum(array_column($items, 'qty'));
            $averagePrice = $totalQuantity > 0 ? $total / $totalQuantity : 0;

            $transaction = Transaction::create([
                'customer_name' => $request->customer_name ?? '-',
                'quantity' => $totalQuantity,
                'price' => $averagePrice,
                'total' => $total,
                'status' => $request->status ?? 'pending',
            ]);


            foreach ($items as $item) {
                $menu = $menus[$item['id']];
                $transaction->details()->create([
                    'menu_id' => $menu->id,
                    'quantity' => $item['qty'],  // sesuaikan dengan migration dan model
                    'price' => $menu->price,
                    'subtotal' => $menu->price * $item['qty'],
                ]);
            }

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('details.menu');
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $transaction->load('details.menu');
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'status' => 'nullable|string',
        ]);

        $transaction->update([
            'customer_name' => $request->customer_name ?? $transaction->customer_name,
            'status' => $request->status ?? $transaction->status,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->details()->delete();
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}

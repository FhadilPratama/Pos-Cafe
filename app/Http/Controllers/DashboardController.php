<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Menu;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total penjualan hari ini (sum 'total' dari transaksi dengan status selesai misal)
        $totalSalesToday = Transaction::whereDate('created_at', Carbon::today())
                                ->where('status', 'paid') // asumsi status selesai
                                ->sum('total');

        // Jumlah transaksi hari ini
        $transactionCountToday = Transaction::whereDate('created_at', Carbon::today())
                                ->where('status', 'paid')
                                ->count();

        // Produk terlaris berdasarkan transaksi detail (jumlah quantity terbanyak)
        $topMenu = DB::table('transaction_details')
            ->select('menu_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('menu_id')
            ->orderByDesc('total_qty')
            ->limit(1)
            ->first();

        $topMenuName = null;
        if ($topMenu) {
            $menu = Menu::find($topMenu->menu_id);
            $topMenuName = $menu ? $menu->name : null;
        }

        // Produk dengan stok hampir habis (jika ada kolom 'stock' di Menu, kalau tidak bisa dihilangkan)
        // Karena model Menu kamu tidak ada kolom 'stock', ini bisa di-skip atau ditambahkan kalau ada.
        $lowStockMenus = collect(); // kosong dulu

        // Grafik penjualan 7 hari terakhir
        $sales = Transaction::select(
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('SUM(total) as total'))
                    ->whereBetween('created_at', [Carbon::now()->subDays(6), Carbon::now()])
                    ->where('status', 'paid')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();

        $salesDates = $sales->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'))->toArray();
        $salesAmounts = $sales->pluck('total')->toArray();

        return view('dashboard.index', compact(
            'totalSalesToday',
            'transactionCountToday',
            'topMenuName',
            'lowStockMenus',
            'salesDates',
            'salesAmounts'
        ));
    }
}

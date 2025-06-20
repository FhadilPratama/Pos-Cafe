<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Exports\LaporanExport;
use App\Imports\LaporanImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->get('tanggal_mulai');
        $tanggalSelesai = $request->get('tanggal_selesai');

        $query = Payment::with('transaction');

        if ($tanggalMulai && $tanggalSelesai) {
            $query->whereBetween('payment_date', [$tanggalMulai . ' 00:00:00', $tanggalSelesai . ' 23:59:59']);
        }

        $payments = $query->orderBy('payment_date', 'desc')->get();

        $laporan = $payments->groupBy(function ($payment) {
            return $payment->payment_date->format('Y-m-d');
        });

        return view('laporan.index', compact('laporan', 'tanggalMulai', 'tanggalSelesai'));
    }

    // Export data ke Excel
    public function exportExcel(Request $request)
    {
        return Excel::download(new LaporanExport, 'laporan.xlsx');
    }

    // Export data ke PDF
    public function exportPDF(Request $request)
    {
        $tanggalMulai = $request->get('tanggal_mulai');
        $tanggalSelesai = $request->get('tanggal_selesai');

        $query = Payment::with('transaction');
        if ($tanggalMulai && $tanggalSelesai) {
            $query->whereBetween('payment_date', [$tanggalMulai . ' 00:00:00', $tanggalSelesai . ' 23:59:59']);
        }
        $payments = $query->orderBy('payment_date', 'desc')->get();

        $total = $payments->sum('jumlah_bayar');

        $pdf = PDF::loadView('laporan.pdf', compact('payments', 'total'));
        return $pdf->download('laporan.pdf');
    }

    // Import data dari Excel
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new LaporanImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data berhasil diimpor.');
    }
}

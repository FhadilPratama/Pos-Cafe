<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    public function index()
    {
        // eager load transaction to avoid n+1 problem
        $payments = Payment::with('transaction')->orderBy('created_at', 'asc')->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $transactionId = $request->get('transaction_id');
        $selectedTransaction = null;

        if ($transactionId) {
            // Pastikan transaksi belum dibayar
            $selectedTransaction = Transaction::whereDoesntHave('payment')->find($transactionId);
            if (!$selectedTransaction) {
                return redirect()->route('payments.index')->withErrors('Transaksi tidak ditemukan atau sudah dibayar.');
            }
            // Kirim hanya transaksi yg dipilih
            return view('payments.create', compact('selectedTransaction'));
        }

        // Jika tidak ada transaction_id, arahkan ke daftar pembayaran saja
        return redirect()->route('payments.index')->withErrors('Transaksi belum dipilih.');
    }



    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id|unique:payments,transaction_id',
            'jumlah_bayar' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);
        $total = $transaction->total;

        $jumlah_bayar = $request->jumlah_bayar;

        if ($jumlah_bayar < $total) {
            return back()->withErrors(['jumlah_bayar' => 'Jumlah bayar tidak boleh kurang dari total transaksi'])->withInput();
        }

        $kembalian = $jumlah_bayar - $total;

        Payment::create([
            'transaction_id' => $transaction->id,
            'jumlah_bayar' => $jumlah_bayar,
            'kembalian' => $kembalian,
            'payment_method' => $request->payment_method,
            'payment_date' => now(),
        ]);

        // update status transaksi jika diperlukan
        $transaction->update(['status' => 'paid']);

        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil disimpan.');
    }

    public function show(Payment $payment)
    {
        $payment->load('transaction.details.menu');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        // buat dropdown transaksi, tapi exclude transaksi yg sudah dibayar kecuali ini sendiri
        $transactions = Transaction::whereDoesntHave('payment')->orWhere('id', $payment->transaction_id)->get();
        return view('payments.edit', compact('payment', 'transactions'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'transaction_id' => "required|exists:transactions,id|unique:payments,transaction_id,{$payment->id}",
            'jumlah_bayar' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);
        $total = $transaction->total;

        $jumlah_bayar = $request->jumlah_bayar;

        if ($jumlah_bayar < $total) {
            return back()->withErrors(['jumlah_bayar' => 'Jumlah bayar tidak boleh kurang dari total transaksi'])->withInput();
        }

        $kembalian = $jumlah_bayar - $total;

        $payment->update([
            'transaction_id' => $transaction->id,
            'jumlah_bayar' => $jumlah_bayar,
            'kembalian' => $kembalian,
            'payment_method' => $request->payment_method,
            'payment_date' => now(),
        ]);

        $transaction->update(['status' => 'paid']);

        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function destroy(Payment $payment)
    {
        $transaction = $payment->transaction;
        $payment->delete();

        // kembalikan status transaksi jika pembayaran dihapus
        if ($transaction) {
            $transaction->update(['status' => 'pending']);
        }

        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil dihapus.');
    }
}

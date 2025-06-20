<?php

namespace App\Imports;

use App\Models\Payment;
use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LaporanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Contoh mengimport data sederhana,
        // Asumsikan file Excel ada kolom: customer_name, total, payment_date, jumlah_bayar
        // Perlu modifikasi sesuai struktur database kamu ya
        
        // Cari transaction berdasarkan customer_name, atau buat baru
        $transaction = Transaction::firstOrCreate([
            'customer_name' => $row['customer_name'],
        ], [
            'total' => $row['total'] ?? 0,
        ]);
        
        return new Payment([
            'transaction_id' => $transaction->id,
            'jumlah_bayar' => $row['total'],  // atau sesuaikan
            'payment_date' => \Carbon\Carbon::parse($row['payment_date']),
        ]);
    }
}

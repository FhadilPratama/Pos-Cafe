<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil semua payment dengan relasi transaction
        return Payment::with('transaction')->get()->map(function($payment) {
            return [
                'No' => $payment->id,
                'Customer' => $payment->transaction->customer_name ?? '-',
                'Total' => $payment->transaction->total ?? 0,
                'Tanggal' => $payment->payment_date->format('d-m-Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Customer', 'Total', 'Tanggal'];
    }
}

<!DOCTYPE html>
<html>
<head>
    <title>Laporan PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #eee;
        }
    </style>
</head>
<body>
    <h2>Laporan Pendapatan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $payment->transaction->customer_name ?? '-' }}</td>
                    <td>Rp {{ number_format($payment->transaction->total ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $payment->payment_date->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Total Keseluruhan</strong></td>
                <td colspan="2"><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

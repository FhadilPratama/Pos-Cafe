<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['transaction_id', 'jumlah_bayar', 'kembalian', 'payment_method', 'payment_date'];
      protected $casts = [
        'payment_date' => 'datetime',  // <-- ini penting
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}

<?php

// app/Models/TransactionDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = ['transaction_id', 'menu_id', 'quantity', 'price', 'subtotal'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}


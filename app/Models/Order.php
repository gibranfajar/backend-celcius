<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";

    protected $fillable = [
        'invoice',
        'user_id',
        'voucher_id',
        'weight',
        'courier',
        'service',
        'service_ongkir',
        'ongkir',
        'discount',
        'total',
        'gross_amount',
        'status',
        'status_payment',
        'resi',
        'payment_token',
        'payment_url',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}

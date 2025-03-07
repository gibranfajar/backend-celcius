<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $fillable = [
        'name',
        'code',
        'type',
        'amount',
        'start_date',
        'end_date',
        'status',
        'description',
        'qty',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaigns';

    protected $fillable = [
        'name',
        'slug',
        'image',
        'category',
        'banner_left',
        'banner_right',
        'banner_center',
        'product1_id',
        'product2_id',
        'product3_id',
        'product4_id',
        'product5_id',
        'product6_id',
    ];

    public function product1()
    {
        return $this->belongsTo(Product::class, 'product1_id');
    }

    public function product2()
    {
        return $this->belongsTo(Product::class, 'product2_id');
    }

    public function product3()
    {
        return $this->belongsTo(Product::class, 'product3_id');
    }

    public function product4()
    {
        return $this->belongsTo(Product::class, 'product4_id');
    }

    public function product5()
    {
        return $this->belongsTo(Product::class, 'product5_id');
    }

    public function product6()
    {
        return $this->belongsTo(Product::class, 'product6_id');
    }
}

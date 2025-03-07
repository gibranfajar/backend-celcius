<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'color_id',
        'collection_id',
        'type',
        'weight',
        'price',
        'discount',
        'article',
        'plu',
        'description',
        'sizechart',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function size()
    {
        return $this->hasMany(Size::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'product1_id')
            ->orWhere('product2_id', $this->id)
            ->orWhere('product3_id', $this->id)
            ->orWhere('product4_id', $this->id)
            ->orWhere('product5_id', $this->id)
            ->orWhere('product6_id', $this->id);
    }
}

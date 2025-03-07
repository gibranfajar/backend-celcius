<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collections';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'banner',
        'category',
    ];

    public function images()
    {
        return $this->hasMany(ImageCollection::class);
    }
}

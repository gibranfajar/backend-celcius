<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageCollection extends Model
{
    protected $table = 'image_collections';

    protected $fillable = [
        'image',
        'collection_id',
    ];

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}

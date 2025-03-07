<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCollection extends Model
{
    protected $table = 'blog_collections';

    protected $fillable = [
        'collection_id',
        'banner',
    ];

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}

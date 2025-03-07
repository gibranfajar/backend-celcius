<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageHome extends Model
{
    protected $table = 'page_homes';

    protected $fillable = [
        'title_bannertop',
        'bannertop_desktop_image',
        'bannertop_mobile_image',
        'toptitleurl_left',
        'topurl_left',
        'toptitleurl_right',
        'topurl_right',
        'title_bannerbottom',
        'bannerbottom_desktop_image',
        'bannerbottom_mobile_image',
        'bottomtitleurl_left',
        'bottomurl_left',
        'bottomtitleurl_right',
        'bottomurl_right',
    ];
}

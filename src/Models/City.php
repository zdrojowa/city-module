<?php

namespace Selene\Modules\CityModule\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class City extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'cities';

    protected $appends = ['id'];
    protected $hidden  = ['_id'];

    protected $primaryKey = '_id';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'titles',
        'labels',
        'descriptions',
        'image',
        'gallery',
        'order'
    ];
}

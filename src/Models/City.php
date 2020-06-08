<?php

namespace Selene\Modules\CityModule\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class City extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'order'
    ];

    /**
     * @var string
     */
    protected $connection = 'mongodb';
}

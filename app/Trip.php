<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon schedule
 * @property int mode
 * @property double start_address_lat
 * @property double start_address_lng
 * @property double end_address_lat
 * @property double end_address_lng
 */
class Trip extends Model
{
    const DRIVER_MODE = 1;
    const RIDER_MODE = 0;

    protected $fillable = [
        'schedule',
        'mode',
        'spaces',
        'end_time',
        'start_address',
        'start_address_lat',
        'start_address_lng',
        'end_address',
        'end_address_lat',
        'end_address_lng',
        'user_name'
    ];

    protected $casts = [
        'end_address_lat' => 'double',
        'end_address_lng' => 'double',
        'start_address_lat' => 'double',
        'start_address_lng' => 'double',
        'mode' => 'int',
        'spaces' => 'int',
    ];

    protected $dates = [
        'schedule',
        'created_at',
        'updated_at'
    ];

    public function isDriver()
    {
        return $this->mode == static::DRIVER_MODE;
    }

    public function getModeNameAttribute()
    {
        return $this->isDriver() ? 'driver' : 'rider';
    }

}

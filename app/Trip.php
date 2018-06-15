<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Location\Coordinate;
use Location\Distance\Vincenty;

/**
 * @property Carbon schedule
 * @property int mode
 * @property double start_address_lat
 * @property double start_address_lng
 * @property double end_address_lat
 * @property double end_address_lng
 * @property int id
 * @property Coordinate start_location
 * @property Coordinate end_location
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

    public function getStartLocationAttribute()
    {
        return new Coordinate($this->start_address_lat, $this->start_address_lat);
    }

    public function getEndLocationAttribute()
    {
        return new Coordinate($this->end_address_lat, $this->end_address_lat);
    }

    public function distanceToStart(Coordinate $coordinate)
    {
        return $this->start_location->getDistance($coordinate, new Vincenty());
    }

    public function distanceToEnd(Coordinate $coordinate)
    {
        return $this->end_location->getDistance($coordinate, new Vincenty());
    }

}

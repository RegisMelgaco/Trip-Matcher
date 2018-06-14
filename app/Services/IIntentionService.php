<?php
/**
 * Created by PhpStorm.
 * User: regis
 * Date: 06/06/18
 * Time: 14:59
 */

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface IIntentionService
{
    /**
     * Get all trips from specified date
     *
     * @param Carbon $date
     * @return Collection
     */
    public function getIntentions(Carbon $date): Collection;
}
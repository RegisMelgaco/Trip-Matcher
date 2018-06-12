<?php
/**
 * Created by PhpStorm.
 * User: regis
 * Date: 06/06/18
 * Time: 14:59
 */

namespace App\Services;

use Carbon\Carbon;

interface IIntentionService
{
    /**
     * Get all trips from specified date
     *
     * @param Carbon $date
     * @return array
     */
    public function getIntentions(Carbon $date);

    /**
     * Get all trips from specified date
     *
     * @param Carbon $date
     * @return array
     */
    public function getIntentionsCompatibleWith($trip);
}
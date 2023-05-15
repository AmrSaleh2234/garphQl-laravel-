<?php

namespace App\Http\Services;

use Carbon\Carbon;

class AttendanceService
{
    public static function checkIfHolidays($date)
    {
        $day = Carbon::parse($date)->format("l");
        return $day=="Saturday"|| $day=="Friday";
    }
}

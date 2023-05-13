<?php

namespace App\Http\Repository;

use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceRepository
{
    public static function getLastAttendanceFoUser($user_id) :Attendance
    {
        return Attendance::where("user_id", $user_id)
            ->orderBy("date", "DESC")
            ->first()->date;
    }


    public static function createAttendace($user_id,$date,$attendance=null) : Attendance
    {
       return Attendance::create([
            "user_id" => $user_id,
            "attendance" => $attendance,
            "date" => $date
        ]);
    }
}

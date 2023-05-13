<?php

namespace App\GraphQL\Mutations;

use App\Http\Repository\AttendanceRepository;
use App\Http\Services\AttendanceService;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

final class CreateAttendance
{
    /**
     * @param null $_
     * @param array{} $args
     */
    public function __invoke($_, array $args)
    {
        $lastDateAttendance = AttendanceRepository::getLastAttendanceFoUser($args['user_id']);//get last date attendance
        $diffInDays = Carbon::parse($lastDateAttendance)->diffInDays(Carbon::now("EEST")->format("Y-m-d"));

        if ($lastDateAttendance && $diffInDays >= 2) //if lost days >=2 it is absent days
            for ($i = 1; $i < $diffInDays; $i++) {
                $lostDay = Carbon::parse($lastDateAttendance)->addDay($i)->format("Y-m-d");//add day to last day attendance
                if (AttendanceService::checkIfHolidays($lostDay)) //check day is holiday
                    AttendanceRepository::createAttendace($args['user_id'], $lostDay);
            }

        return AttendanceRepository::createAttendace(
            $args['user_id'], Carbon::now("EEST")->format("Y-m-d"), Carbon::now("EEST")->format("H:i:s"),);

    }
}

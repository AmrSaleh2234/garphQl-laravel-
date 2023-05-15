<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Carbon\Carbon;

final class UpdateAttendance
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
       $attendance = User::find($args['user_id'])->attendance()->where("date",Carbon::now("EEST")->format("Y-m-d"))->first();
       if($attendance)
       {
           $attendance->update([
              "departure"=>Carbon::now("EEST")->format("H:i:s"),
               "difference"=>Carbon::createFromFormat("H:i:s",$attendance->attendance)->diffInMinutes(Carbon::now("EEST")->format("H:i:s"))/60
           ]);
           return [
               "attendance"=>$attendance,
               "status"=>1
           ];

       }
        return [
            "attendance"=>$attendance,
            "status"=>0
        ];

    }
}

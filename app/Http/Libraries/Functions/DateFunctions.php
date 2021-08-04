<?php

namespace App\Http\Libraries\Functions;

use Illuminate\Support\Facades\Date;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

trait DateFunctions
{
    protected function getExpiringDate($duration){
        $dt = Date::today()->addDays($duration);
        $new_dt = Date::create($dt->year, $dt->month, $dt->day);
        return $new_dt->toFormattedDateString();
    }

    protected function getCurrentDate(){
        $dt = Date::today();
        $new_dt = Date::create($dt->year, $dt->month, $dt->day);
        return $new_dt->toFormattedDateString();
    }

    protected function parseTimestamp($timestamp){
        $dt = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp);
        return json_decode(json_encode([
            'date' => $dt->format('jS F Y'),
            'time' => $dt->format('h:i A')
        ]));
    }

    protected function getDateInterval($date){
        $dt = Carbon::parse($date)->diffForHumans(Carbon::now());
        return $dt;
    }

}

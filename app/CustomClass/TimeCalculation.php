<?php

namespace App\CustomClass;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use DB;



Class TimeCalculation{ 

    /*Subtract time: (hours with minutes)*/

        public static function subtractTime($initialHour, $finalHour){
            return (date("H:i", strtotime("00:00") + strtotime($finalHour) - strtotime($initialHour)));
        }

    /*Subtract time: (hours with minutes)*/

    /*Subtract time: (hours with minutes and seconds)*/

        // function subtractTime($initialHour, $finalHour){
        //     return (date("H:i:s", strtotime("00:00:00") + strtotime($finalHour) - strtotime($initialHour)));
        // }

    /*Subtract time: (hours with minutes and seconds)*/

    /*Sum  time: (hours with minutes and seconds)*/

        public static function sumTime($initialHour, $finalHour) {
            $time = $initialHour;
            $time2 = $finalHour;

            $secs = strtotime($finalHour)-strtotime("00:00:00");
            $newTime = date("H:i",strtotime($time)+$secs);
            return $newTime;
        }
    
    /*Sum  time: (hours with minutes and seconds)*/

    /*Sum  time: (hours with minutes and seconds)*/

        // function sumTime($initialHour, $finalHour) {
        //     $h = date('H', strtotime($finalHour));
        //     $m = date('i', strtotime($finalHour));
        //     $s = date('s', strtotime($finalHour));
        //     $tmp = $h." hour ".$m." min ".$s." second";
        //     $sumHour = $initialHour." + ".$tmp;
        //     $newTime = date('H:i:s', strtotime($sumHour));
        //     return $newTime;
        // }

    /*Sum  time: (hours with minutes and seconds)*/
} 

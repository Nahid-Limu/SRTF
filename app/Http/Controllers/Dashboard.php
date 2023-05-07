<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use App\Employee;
use App\Shift;
use App\Designation;
use DB;
use App\CustomClass\TimeCalculation;
class Dashboard extends Controller
{
    public function index()
    {
        $ToatalEmployee = Employee::all()->Count();
        $ToatalDesignation = Designation::all()->Count();
        $ToatalShift = Shift::all()->Count();
        $WorkHour = DB::table('attendances')
                    ->select( DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( work_time) ) ) as total_work_time") )
                    ->get();
                    
        // dd($WorkHour[0]->total_work_time);
        return view('dashboard', compact('ToatalEmployee','ToatalDesignation','ToatalShift','WorkHour') );
    }
}

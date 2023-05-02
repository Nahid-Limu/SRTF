<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Employee;
use App\Shift;
use App\Designation;
use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // dd( $request->all() );
        $ReportData = DB::table('attendances')
            // ->join('employees', 'attendances.employee_id', '=', 'employees.id')
            
            // ->select('employees.id','employees.employee_name')
            // ->groupBy('attendances.employees_id')
            ->get();
        dd($ReportData );
        
        return view('report');
    }
}

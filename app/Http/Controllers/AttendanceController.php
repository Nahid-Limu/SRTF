<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Employee;
use App\Shift;
use App\Designation;
use Illuminate\Http\Request;
use DB;
use App\CustomClass\TimeCalculation;

class AttendanceController extends Controller
{
    public function index()
    {
        
        $Employees = DB::table('employees')
                    ->join('shifts', 'employees.shift_id', '=', 'shifts.id')
                    ->select('employees.id','employees.employee_name','employees.employee_code','shifts.id as shifts_id','shifts.shift_name','shifts.entry_time','shifts.exit_time')
                    ->get();
        // dd($Employees );
        
        if(request()->ajax())
        {
            return datatables()->of($Employees)
                    
                    ->editColumn('shift', function ($data) {
                        // $button =$data->shift_name."<br>". (date('h:i A', strtotime($data->entry_time)) ." To ".  date('h:i A', strtotime($data->exit_time)));
                        $button =$data->shift_name;
                        return $button;
                    })
                    

                    ->addColumn('checkIn', function($data){
                        $checkIn = 1;
                        $shiftsId = $data->shifts_id;

                        $AttendanceData = Attendance::where('employee_id', $data->id)->whereDate('attendances_date', date("Y-m-d") )->where('status',2)->first();
                        
                        $Attendance = Attendance::where('employee_id', $data->id)->whereRaw('Date(created_at) = attendances_date')->where('status',1)->count('Check_in');

                        if ($Attendance <= 0 && $AttendanceData['attendances_date'] != date("Y-m-d") ) {
                            $button = '<button type="button"  onclick="checkInOut('.$data->id.', '.$checkIn.','.$shiftsId.' )" name="checkIn" id="'.$data->id.'" class="delete btn btn-success btn-sm" data-placement="top" title="Check In"  "><i class="fa fa-check"> checkIn</i></button></div>';
                        } else {
                            $button = '<button type="button" disabled  onclick="checkInOut('.$data->id.',\''.$checkIn.'\')" name="checkIn" id="'.$data->id.'" class="delete btn btn-success btn-sm" data-placement="top" title="Check In"  "><i class="fa fa-check"> checkIn</i></button></div>';
                        }
                        
                        return $button;
                    })

                    ->addColumn('checkOut', function($data){
                        
                        $checkOut = 2;
                        $shiftsId = $data->shifts_id;
                        $Attendance = Attendance::where('employee_id', $data->id)->whereRaw('Date(created_at) = attendances_date')->where('status',1)->count('Check_in');
                        
                        if ($Attendance == 1) {
                            $button = '<button type="button" onclick="checkInOut('.$data->id.', '.$checkOut.','.$shiftsId.' )" name="checkOut" id="'.$data->id.'" class="delete btn btn-danger btn-sm" data-placement="top" title="Check Out"  "><i class="fa fa-times"> checkOut</i></button></div>';
                        } else {
                            $button = '<button type="button" disabled onclick="checkInOut('.$data->id.',\''.$checkOut.'\')" name="checkOut" id="'.$data->id.'" class="delete btn btn-danger btn-sm" data-placement="top" title="Check Out"  "><i class="fa fa-times"> checkOut</i></button></div>';
                        }
                        return $button;
                    })


                    ->addColumn('breakfast', function($data){
                        $breakfast_start = 1;
                        $breakfast_end = 0;
                        
                        $Attendance = Attendance::where('employee_id', $data->id)->where('status',1)->whereRaw('Date(created_at) = attendances_date')->count('Check_in');
                        $Break_start = Attendance::where('employee_id', $data->id)->where('status', 1)->whereRaw('Date(created_at) = attendances_date')->whereNotNull('break_start')->count('break_start');
                        $Break_end = Attendance::where('employee_id', $data->id)->where('status', 1)->whereRaw('Date(created_at) = attendances_date')->whereNotNull('break_end')->count('break_end');
                        
                        if ($Attendance == 1) {

                            if ($Break_start == 1 && $Break_end != 1) {

                                $button = '<div class="d-flex justify-content-center"><button type="button" disabled onclick="breakOnOff('.$data->id.',\''.$breakfast_start.'\')" name="edit" id="'.$data->id.'" class="edit btn btn-info btn-sm d-flex justify-content-center" data-placement="top" title="Start"><i class="fa fa-hourglass-start" "> Start</i></button>';
                                $button .= '&nbsp;<button type="button" onclick="breakOnOff('.$data->id.',\''.$breakfast_end.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-warning btn-sm" data-placement="top" title="End"  "><i class="fa fa-hourglass-end"> End</i></button></div>';
                            
                            } else if ($Break_end == 1 && $Break_start == 1) {

                                $button = '<div class="d-flex justify-content-center"><button type="button" disabled onclick="breakOnOff('.$data->id.',\''.$breakfast_start.'\')" name="edit" id="'.$data->id.'" class="edit btn btn-info btn-sm d-flex justify-content-center" data-placement="top" title="Start"><i class="fa fa-hourglass-start" "> Start</i></button>';
                                $button .= '&nbsp;<button type="button" disabled onclick="breakOnOff('.$data->id.',\''.$breakfast_end.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-warning btn-sm" data-placement="top" title="End"  "><i class="fa fa-hourglass-end"> End</i></button></div>';
                            
                            } else {
                                $button = '<div class="d-flex justify-content-center"><button type="button"  onclick="breakOnOff('.$data->id.',\''.$breakfast_start.'\')" name="edit" id="'.$data->id.'" class="edit btn btn-info btn-sm d-flex justify-content-center" data-placement="top" title="Start"><i class="fa fa-hourglass-start" "> Start</i></button>';
                                $button .= '&nbsp;<button type="button"  onclick="breakOnOff('.$data->id.',\''.$breakfast_end.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-warning btn-sm" data-placement="top" title="End"  "><i class="fa fa-hourglass-end"> End</i></button></div>';
                            }

                        } else {
                            $button = '<div class="d-flex justify-content-center"><button type="button" disabled onclick="breakOnOff('.$data->id.',\''.$breakfast_start.'\')" name="edit" id="'.$data->id.'" class="edit btn btn-info btn-sm d-flex justify-content-center" data-placement="top" title="Start"><i class="fa fa-hourglass-start" "> Start</i></button>';
                            $button .= '&nbsp;<button type="button" disabled onclick="breakOnOff('.$data->id.',\''.$breakfast_end.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-warning btn-sm" data-placement="top" title="End"  "><i class="fa fa-hourglass-end"> End</i></button></div>';
                        }
                        
                        
                        return $button;
                    })


                    ->addColumn('lunch', function($data){
                        $lunchStart = 1;
                        $lunchEnd = 0;
                        
                        $Attendance = Attendance::where('employee_id', $data->id)->where('status', 1)->whereRaw('Date(created_at) = attendances_date')->count('Check_in');
                        $Lunch_start = Attendance::where('employee_id', $data->id)->where('status', 1)->whereRaw('Date(created_at) = attendances_date')->whereNotNull('lunch_start')->count('lunch_start');
                        $Lunch_end = Attendance::where('employee_id', $data->id)->where('status', 1)->whereRaw('Date(created_at) = attendances_date')->whereNotNull('lunch_end')->count('lunch_end');
                        
                        if ($Attendance == 1) {

                            if ($Lunch_start == 1 && $Lunch_end != 1) {

                                $button = '<div class="d-flex justify-content-center"><button type="button" disabled onclick="lunchOnOff('.$data->id.',\''.$lunchStart.'\')" name="edit" id="'.$data->id.'" class="edit btn btn-info btn-sm d-flex justify-content-center" data-placement="top" title="Start"><i class="fa fa-hourglass-start" "> Start</i></button>';
                                $button .= '&nbsp;<button type="button" onclick="lunchOnOff('.$data->id.',\''.$lunchEnd.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-warning btn-sm" data-placement="top" title="End"  "><i class="fa fa-hourglass-end"> End</i></button></div>';
                            
                            } else if ($Lunch_end == 1 && $Lunch_start == 1) {

                                $button = '<div class="d-flex justify-content-center"><button type="button" disabled onclick="lunchOnOff('.$data->id.',\''.$lunchStart.'\')" name="edit" id="'.$data->id.'" class="edit btn btn-info btn-sm d-flex justify-content-center" data-placement="top" title="Start"><i class="fa fa-hourglass-start" "> Start</i></button>';
                                $button .= '&nbsp;<button type="button" disabled onclick="lunchOnOff('.$data->id.',\''.$lunchEnd.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-warning btn-sm" data-placement="top" title="End"  "><i class="fa fa-hourglass-end"> End</i></button></div>';
                                
                            } else {
                                $button = '<div class="d-flex justify-content-center"><button type="button" onclick="lunchOnOff('.$data->id.',\''.$lunchStart.'\')" name="edit" id="'.$data->id.'" class="edit btn btn-info btn-sm d-flex justify-content-center" data-placement="top" title="Start"><i class="fa fa-hourglass-start" "> Start</i></button>';
                                $button .= '&nbsp;<button type="button" onclick="lunchOnOff('.$data->id.',\''.$lunchEnd.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-warning btn-sm" data-placement="top" title="End"  "><i class="fa fa-hourglass-end"> End</i></button></div>';
                            }

                        } else {
                                $button = '<div class="d-flex justify-content-center"><button type="button" disabled onclick="lunchOnOff('.$data->id.',\''.$lunchStart.'\')" name="edit" id="'.$data->id.'" class="edit btn btn-info btn-sm d-flex justify-content-center" data-placement="top" title="Start"><i class="fa fa-hourglass-start" "> Start</i></button>';
                                $button .= '&nbsp;<button type="button" disabled onclick="lunchOnOff('.$data->id.',\''.$lunchEnd.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-warning btn-sm" data-placement="top" title="End"  "><i class="fa fa-hourglass-end"> End</i></button></div>';
                        }


                        return $button;
                    })

                    
                    ->rawColumns(['shift','checkIn','breakfast','lunch','checkOut'])
                    ->addIndexColumn()
                    ->make(true);
                    
        }
        return view('attendance');
    }

    public function checkInOut($eid,$check,$shiftsId)
    {
        // dd( gettype($check) );
        $today = date("Y-m-d");
        $timeNow = date('H:i',time());

        $Attendance = Attendance::where('employee_id', $eid)
                    ->whereDate('created_at', $today )
                    ->count();
        // dd( $Attendance );

        if ( $Attendance <= 0 && $check == 1 ) {
            // dd( 'checkin' );
            $Attendance = new Attendance;
            $Attendance->employee_id = $eid;
            $Attendance->shift_id = $shiftsId;
            $Attendance->attendances_date = $today;
            $Attendance->Check_in = date('H:i',time());
            $Attendance->status = $check;
            $Attendance->save();
            // dd( $Attendance->id);

            if ($Attendance->id) {
                return response()->json(['success' => 'Check In successfully.']);
            } else {
                return response()->json(['failed' => 'Check In failed.']);
            }
        }else {

            $AttendanceData = Attendance::where('employee_id', $eid)
                            ->whereRaw('Date(created_at) = attendances_date')
                            ->where('status',1)
                            ->first();
            
            $Work_time = TimeCalculation::subtractTime( $AttendanceData->Check_in, date('H:i',time()) );
            $break_time = TimeCalculation::subtractTime( $AttendanceData->break_start, $AttendanceData->break_end );
            $lunch_time = TimeCalculation::subtractTime( $AttendanceData->lunch_start, $AttendanceData->lunch_end );
            
            $total_break = TimeCalculation::sumTime( $lunch_time, $break_time );
            $total_Work_time = TimeCalculation::subtractTime( $total_break, $Work_time );
            // dd( $total_Work_time,$Work_time, $total_break );
            
            $Attendance = DB::table('attendances')
                        ->where('employee_id', $eid)
                        ->whereDate('created_at', $today )
                        ->update([
                            'Check_out' => date('H:i',time()) ,
                            'status' => $check,
                            'total_break' => $total_break,
                            'work_time' => $total_Work_time,
                        ]);

            // dd( $Attendance);
            if ($Attendance) {
                return response()->json(['success' => 'Check Out successfully.']);
            } else {
                return response()->json(['failed' => 'Check Out failed.']);
            }
        }
        
    }

    public function breakFast($eid,$breakfast)
    {
        $today = date("Y-m-d");
        $timeNow= date('H:i',time());

        $Attendance = Attendance::where('employee_id', $eid)
                    ->whereDate('created_at', $today )
                    ->where('status', 1)
                    ->count('Check_in');
        // dd($Attendance );

        if ($Attendance == 1 && $breakfast == 1) {
            // dd( 'break st' );
            $Attendance = DB::table('attendances')
                        ->where('employee_id', $eid)
                        ->where('status', 1)
                        ->update([
                            'break_start' => $timeNow 
                        ]);

            if ($Attendance ) {
                return response()->json(['success' => 'Break Start successfully.']);
            } else {
                return response()->json(['failed' => 'Break Start failed.']);
            }
        }else {
            // dd( 'break end' );
            $Attendance = DB::table('attendances')
                        ->where('employee_id', $eid)
                        ->where('status', 1)
                        ->update([
                            'break_end' => $timeNow
                        ]);

            if ($Attendance) {
                return response()->json(['success' => 'Break End successfully.']);
            } else {
                return response()->json(['failed' => 'Break End failed.']);
            }
        }
        
    }

    public function lunch($eid,$lunch)
    {
        $today = date("Y-m-d");
        $timeNow= date('H:i',time());

        $Attendance = Attendance::where('employee_id', $eid)
                    ->whereDate('created_at', $today )
                    ->where('status', 1)
                    ->count('Check_in');
        // dd($lunch );

        if ($Attendance == 1 && $lunch == 1) {
            // dd( 'break st' );
            $Attendance = DB::table('attendances')
                        ->where('employee_id', $eid)
                        ->where('status', 1)
                        ->update([
                            'lunch_start' => $timeNow 
                        ]);

            if ($Attendance ) {
                return response()->json(['success' => 'Lunch Time Start successfully.']);
            } else {
                return response()->json(['failed' => 'Lunch Time Start failed.']);
            }
        }else {
            // dd( 'break end' );
            $Attendance = DB::table('attendances')
                        ->where('employee_id', $eid)
                        ->where('status', 1)
                        ->update([
                            'lunch_end' => $timeNow
                        ]);

            if ($Attendance) {
                return response()->json(['success' => 'Lunch Time End successfully.']);
            } else {
                return response()->json(['failed' => 'Lunch Time End failed.']);
            }
        }
        
    }
}

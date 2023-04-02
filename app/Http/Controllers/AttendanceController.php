<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Employee;
use App\Shift;
use App\Designation;
use Illuminate\Http\Request;
use DB;

class AttendanceController extends Controller
{
    public function index()
    {
        // $Break_end = Attendance::where('employee_id', 1)->where('status', 1)->whereDate('created_at', date("Y-m-d") )->whereNotNull('break_end')->count('break_end');
        // dd($Break_end );
        // $t=time();
        // echo(date('h:i',$t));
        $Employees = DB::table('employees')
            // ->join('designations', 'employees.designation_id', '=', 'designations.id')
            // ->join('attendances', 'employees.id', '=', 'attendances.employee_id')
            ->join('shifts', 'employees.shift_id', '=', 'shifts.id')
            
            ->select('employees.id','employees.employee_name','employees.employee_code','shifts.shift_name','shifts.entry_time','shifts.exit_time')
            ->get();
        // dd($Employees );

        
        if(request()->ajax())
        {
            return datatables()->of($Employees)
                    
                    // ->addColumn('action', function($data){
                    //     $button = '<button type="button" onclick="deleteModal('.$data->id.',\''.$data->employee_name.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-sm" data-toggle="modal" data-target="#DeleteConfirmationModal" data-placement="top" title="Delete"  style="color: red"><i class="fa fa-trash"> Delete</i></button></div>';
                        
                    //     return $button;
                    // })

                    ->editColumn('shift', function ($data) {
                        $button =$data->shift_name."<br>". (date('h:i A', strtotime($data->entry_time)) ." To ".  date('h:i A', strtotime($data->exit_time)));
                        return $button;
                    })
                    

                    ->addColumn('checkIn', function($data){
                        $checkIn = 1;
                        // $today = date("Y-m-d");
                        $Attendance = Attendance::where('employee_id', $data->id)->whereDate('created_at', date("Y-m-d") )->count('Check_in');
                        if ($Attendance <= 0) {
                            $button = '<button type="button"  onclick="checkInOut('.$data->id.',\''.$checkIn.'\')" name="checkIn" id="'.$data->id.'" class="delete btn btn-success btn-sm" data-placement="top" title="Check In"  "><i class="fa fa-check"> checkIn</i></button></div>';
                        } else {
                            $button = '<button type="button" disabled  onclick="checkInOut('.$data->id.',\''.$checkIn.'\')" name="checkIn" id="'.$data->id.'" class="delete btn btn-success btn-sm" data-placement="top" title="Check In"  "><i class="fa fa-check"> checkIn</i></button></div>';
                        }
                        
                        
                        
                        return $button;
                    })

                    ->addColumn('checkOut', function($data){
                        $checkOut = 0;
                        $Attendance = Attendance::where('employee_id', $data->id)->where('status', 1)->whereDate('created_at', date("Y-m-d") )->count('Check_in');
                        if ($Attendance == 1) {
                            $button = '<button type="button" onclick="checkInOut('.$data->id.',\''.$checkOut.'\')" name="checkOut" id="'.$data->id.'" class="delete btn btn-danger btn-sm" data-placement="top" title="Check Out"  "><i class="fa fa-times"> checkOut</i></button></div>';
                        } else {
                            $button = '<button type="button" disabled onclick="checkInOut('.$data->id.',\''.$checkOut.'\')" name="checkOut" id="'.$data->id.'" class="delete btn btn-danger btn-sm" data-placement="top" title="Check Out"  "><i class="fa fa-times"> checkOut</i></button></div>';
                        }
                        return $button;
                    })


                    ->addColumn('breakfast', function($data){
                        $breakfast_start = 1;
                        $breakfast_end = 0;
                        $Attendance = Attendance::where('employee_id', $data->id)->where('status', 1)->whereDate('created_at', date("Y-m-d") )->count('Check_in');
                        $Break_start = Attendance::where('employee_id', $data->id)->where('status', 1)->whereDate('created_at', date("Y-m-d") )->whereNotNull('break_start')->count('break_start');
                        $Break_end = Attendance::where('employee_id', $data->id)->where('status', 1)->whereDate('created_at', date("Y-m-d") )->whereNotNull('break_end')->count('break_end');
                        
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
                        $lunch_start = 1;
                        $lunch_end = 0;
                        
                        $button = '<div class="d-flex justify-content-center"><button type="button" onclick="lunchOnOff('.$data->id.',\''.$lunch_start.'\')" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm d-flex justify-content-center" data-placement="top" title="Start"><i class="fa fa-hourglass-start" "> Start</i></button>';
                        $button .= '&nbsp;<button type="button" onclick="lunchOnOff('.$data->id.',\''.$lunch_end.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-secondary btn-sm" data-placement="top" title="End"  "><i class="fa fa-hourglass-end"> End</i></button></div>';
                        

                        return $button;
                    })

                    

                    ->rawColumns(['shift','checkIn','breakfast','lunch','checkOut'])
                    ->addIndexColumn()
                    ->make(true);
                    
        }
        return view('attendance');
    }

    public function checkInOut($eid,$check)
    {

        $today = date("Y-m-d");
        $timeNow= date('h:i',time());

        $Attendance = Attendance::where('employee_id', $eid)
                    ->whereDate('created_at', $today )
                    ->count();
        // dd( $Attendance );

        if ($Attendance <= 0 && $check == 1) {
            // dd( 'checkin' );
            $Attendance = new Attendance;
            $Attendance->employee_id = $eid;
            $Attendance->Check_in = $timeNow;
            $Attendance->status = $check;
            $Attendance->save();
            // dd( $Attendance->id);

            if ($Attendance->id) {
                return response()->json(['success' => 'Check In successfully.']);
            } else {
                return response()->json(['failed' => 'Check In failed.']);
            }
        }else {
           
            $Attendance = DB::table('attendances')
                ->where('employee_id', $eid)
                ->update([
                    'Check_out' => $timeNow ,
                    'status' => $check
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
        $timeNow= date('h:i',time());

        $Attendance = Attendance::where('employee_id', $eid)
                    ->whereDate('created_at', $today )
                    ->count('Check_in');
        // dd($Attendance );

        if ($Attendance == 1 && $breakfast == 1) {
            // dd( 'break st' );
            $Attendance = DB::table('attendances')
                ->where('employee_id', $eid)
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
        $timeNow= date('h:i',time());

        $Attendance = Attendance::where('employee_id', $eid)
                    ->whereDate('created_at', $today )
                    ->count('Check_in');
        dd($lunch );

        // if ($Attendance == 1 && $breakfast == 1) {
        //     // dd( 'break st' );
        //     $Attendance = DB::table('attendances')
        //         ->where('employee_id', $eid)
        //         ->update([
        //             'break_start' => $timeNow 
        //         ]);

        //     if ($Attendance ) {
        //         return response()->json(['success' => 'Break Start successfully.']);
        //     } else {
        //         return response()->json(['failed' => 'Break Start failed.']);
        //     }
        // }else {
        //     // dd( 'break end' );
        //     $Attendance = DB::table('attendances')
        //         ->where('employee_id', $eid)
        //         ->update([
        //             'break_end' => $timeNow
        //         ]);

        //     if ($Attendance) {
        //         return response()->json(['success' => 'Break End successfully.']);
        //     } else {
        //         return response()->json(['failed' => 'Break End failed.']);
        //     }
        // }
        
    }
}

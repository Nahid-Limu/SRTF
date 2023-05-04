<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Employee;
use App\Shift;
use App\Designation;
use Illuminate\Http\Request;
use DB;
use App\User;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // dd( $request->all() );
        $dates = [
            'from' => $request->from,
            'to' => $request->to
        ];
        $employee_id = $request->employee_id;

        if ( isset($request->from) ) {

            $ReportData = DB::table('attendances')
                        ->join('employees', 'attendances.employee_id', '=', 'employees.id') 
                        ->join('designations', 'employees.designation_id', '=', 'designations.id') 
                        ->select(
                            'employees.id','employees.employee_name','employees.employee_code',
                            DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( work_time) ) ) as work_time"),
                            DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( total_break) ) ) as total_break"),
                            DB::raw(" (SEC_TO_TIME( SUM( TIME_TO_SEC( work_time) ) ) * designations.salary)/10000  as total_salary"),
                            'designations.salary',
                            )
                        ->groupBy('employee_id')
                        ->whereBetween('attendances.attendances_date', [$request->from, $request->to]);
                        
                        if($request->employee_id != "all") {
                            $ReportData = $ReportData->where('attendances.employee_id', $request->employee_id);
                        }

                        $ReportData = $ReportData->get();

            // dd($ReportData );
            if (count($ReportData)>0) {
                return view('report', compact('ReportData','dates','employee_id') );
            }

        }elseif (isset($request->btnExport)) {
            
            $ReportData = DB::table('attendances')
                        ->join('employees', 'attendances.employee_id', '=', 'employees.id') 
                        ->join('designations', 'employees.designation_id', '=', 'designations.id') 
                        ->select(
                           'employees.employee_name','employees.employee_code',
                            DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( total_break) ) ) as total_break"),
                            DB::raw("SEC_TO_TIME( SUM( TIME_TO_SEC( work_time) ) ) as work_time"),
                            'designations.salary',
                            DB::raw(" (SEC_TO_TIME( SUM( TIME_TO_SEC( work_time) ) ) * designations.salary)/10000  as total_salary"),
                            
                            )
                        ->groupBy('employee_id')
                        ->whereBetween('attendances.attendances_date', [$request->exp_from, $request->exp_to]);
                        
                        if($request->employee_id != "all") {
                            $ReportData = $ReportData->where('attendances.employee_id', $request->employee_id);
                        }

                        $ReportData = $ReportData->get();
            
            // $discount = Discount::whereBetween('created_at', [$request->exp_from, $request->exp_to])->sum('discount_amount');
            // $expense = DailyExpense::whereBetween('created_at', [$request->exp_from, $request->exp_to])->sum('ammount');

            $headers = ['Name','Id No','Break Hour','Working Hour','Salary BDT/hr','Salary (Total)'];
            // $discount = ['','','DISCOUNT','=>',$discount];
            // $expense = ['','','EXPENSE','=>',$expense];
            $dates = ['FROM',$request->exp_from,'','TO',$request->exp_to];
            
            // dd( $dates );
             return $this->download($ReportData,$headers, "Report-$request->exp_from-to-$request->exp_to.csv",$dates);
        }

        
        
        return view('report');
    }

    private function download($data,$header,$filename,$dates)
    {
        
        $export = "----------------------REPORT---------------------"."\n";
        $export .= implode(",",$dates)."\n";
        $export .="----------------------------------------------------"."\n";
        $export .= implode(",",$header)."\n";

        $data = json_decode(json_encode($data), true);
        foreach($data as $key=>$val)
        {
            $export .= implode(",",$val)."\n";
        }

        $export .="----------------------------------------------------"."\n";
        // $export .= implode(",",$discount)."\n";
        // $export .= implode(",",$expense)."\n";
        
        $export = mb_convert_encoding($export,"SJIS", "UTF-8");
        $filename = mb_convert_encoding($filename,"SJIS", "UTF-8");
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename='.$filename);
        echo $export;
        exit();
    }
}

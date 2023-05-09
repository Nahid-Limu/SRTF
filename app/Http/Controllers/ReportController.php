<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Employee;
use App\Shift;
use App\Designation;
use Illuminate\Http\Request;
use DB;
use App\User;
use App\CustomClass\TimeCalculation;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        
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
                            // DB::raw(" (SEC_TO_TIME( SUM( TIME_TO_SEC( work_time) ) ) * designations.salary)/10000  as total_salary"),
                            'designations.salary',
                            )
                        ->groupBy('employee_id');

                        if (isset($request->from, $request->to)) {
                            $ReportData = $ReportData->whereBetween('attendances.attendances_date', [$request->from, $request->to]);
                          }else{
                            $ReportData =  $ReportData->whereDate('attendances.attendances_date', $request->from);
                          }

                        
                        
                        if($request->employee_id != "all") {
                            $ReportData = $ReportData->where('attendances.employee_id', $request->employee_id);
                        }

                        $ReportData = $ReportData->get();

                    // dd($ReportData );
            if (count($ReportData)>0) {
                return view('report', compact('ReportData','dates','employee_id') );
            }else{
                $message = 'No Data Found.';
                return view('report', compact('message') );
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
        

            // ReMake Array
                $newData =[];
                foreach ($ReportData as $arraykey => $arrayData) {

                    $totalSalary = TimeCalculation::HourlyRateCalculator($arrayData->salary,$arrayData->work_time);
                    $key ='total_salary';
                    $new_key ='total_salary';
                    $new_value =$totalSalary;
                    
                    
                    $array = (array)$arrayData;
                    $data =  $this->array_insert_after($key, $array, $new_key, $new_value);
                    $newData[$arraykey] =$data;
                    

                }
                // dd($newData);
            // ReMake Array
            
            $headers = ['Name','Id No','Break Hour','Working Hour','Salary BDT/hr','Salary (Total)'];
            $dates = ['FROM',$request->exp_from,'','TO',$request->exp_to];

            // dd( $dates );
             return $this->download($newData,$headers, "Report-$request->exp_from-to-$request->exp_to.csv",$dates);
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
        
        $export = mb_convert_encoding($export,"SJIS", "UTF-8");
        $filename = mb_convert_encoding($filename,"SJIS", "UTF-8");
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename='.$filename);
        echo $export;
        exit();
    }

    private function array_insert_after($key, array &$array, $new_key, $new_value) {
        if (array_key_exists($key, $array)) {
            $new = array();
            foreach ($array as $k => $value) {
            $new[$k] = $value;
            if ($k === $key) {
                $new[$new_key] = $new_value;
            }
            }
            return $new;
        }
        return FALSE;
    }
}

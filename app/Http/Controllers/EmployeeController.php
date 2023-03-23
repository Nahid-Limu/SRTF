<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Shift;
use App\Designation;
use Illuminate\Http\Request;
use DB;
class EmployeeController extends Controller
{
    public function index()
    {
        $Employees = DB::table('employees')
            ->join('designations', 'employees.designation_id', '=', 'designations.id')
            ->join('shifts', 'employees.shift_id', '=', 'shifts.id')
            ->select('employees.id','employees.employee_name','employees.employee_code','employees.employee_phone','designations.designation_name','designations.salary','shifts.entry_time','shifts.exit_time')
            // ->orderBy('products.group_id','products.company_id')
            ->get();
        // dd($Employees );
        if(request()->ajax())
        {
            return datatables()->of($Employees)
                    
                    ->addColumn('action', function($data){
                        $button = '<button type="button" onclick="deleteModal('.$data->id.',\''.$data->employee_name.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-sm" data-toggle="modal" data-target="#DeleteConfirmationModal" data-placement="top" title="Delete"  style="color: red"><i class="fa fa-trash"> Delete</i></button></div>';
                        
                        return $button;
                    })
                    // ->editColumn('entry_time', function ($Shift) {
                    //     return date('h:i A', strtotime($Shift->entry_time));
                    // })
                    ->editColumn('designation', function ($data) {
                        return $data->designation_name.' - '.$data->salary.' BDT/hr';
                    })
                    ->editColumn('time', function ($data) {
                        return ( date('h:i A', strtotime($data->entry_time)) ." To ".  date('h:i A', strtotime($data->exit_time)));
                    })
                    // ->editColumn('break_time', function ($Shift) {
                    //     return date('h:i', strtotime($Shift->break_time))." Hr";
                    // })

                    // ->addColumn('work_time', function($data){
                    //     return ( date( "H:i", strtotime("00:00") + strtotime($data->exit_time) - strtotime($data->entry_time) - strtotime($data->break_time)  ) );
                        
                    //     return $button;
                    // })

                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
                    
        }

        $Designation = Designation::all();
        $Shift = Shift::all();
        return view('employee', compact( 'Designation', 'Shift' ) );
    }

    public function addEmployee(Request $request)
    {
        $totalEmp = Employee::count()+1;
        // dd();
        $Employee = new Employee;
        $Employee->employee_name = $request->employee_name;
        $Employee->employee_code = 'SRTF'.'-'.$totalEmp;
        $Employee->employee_phone = $request->employee_phone;
        $Employee->designation_id = $request->designation_id;
        $Employee->shift_id = $request->shift_id;
        $Employee->status = 0;
        $Employee->save();

        if ($Employee->id) {
            return response()->json(['success' => 'Added successfully.']);
        } else {
            return response()->json(['failed' => 'Added failed.']);
        }
    }
}

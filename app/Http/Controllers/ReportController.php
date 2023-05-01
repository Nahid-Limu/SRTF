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
    public function index()
    {

        // $Designation = Designation::all();
        
        // if(request()->ajax())
        // {
        //     return datatables()->of($Designation)
                    
        //             ->addColumn('action', function($data){
        //                 $button = '<button type="button" onclick="deleteModal('.$data->id.',\''.$data->designation_name.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-sm" data-toggle="modal" data-target="#DeleteConfirmationModal" data-placement="top" title="Delete"  style="color: red"><i class="fa fa-trash"> Delete</i></button></div>';
                        
        //                 return $button;
        //             })
        //             ->rawColumns(['action'])
        //             ->addIndexColumn()
        //             ->make(true);
                    
        // }
        return view('report');
    }
}

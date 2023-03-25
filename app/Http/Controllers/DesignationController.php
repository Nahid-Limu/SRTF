<?php

namespace App\Http\Controllers;

use App\Designation;
use Illuminate\Http\Request;
use DB;

class DesignationController extends Controller
{
    
    public function index()
    {

        $Designation = Designation::all();
        
        if(request()->ajax())
        {
            return datatables()->of($Designation)
                    
                    ->addColumn('action', function($data){
                        $button = '<button type="button" onclick="deleteModal('.$data->id.',\''.$data->designation_name.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-sm" data-toggle="modal" data-target="#DeleteConfirmationModal" data-placement="top" title="Delete"  style="color: red"><i class="fa fa-trash"> Delete</i></button></div>';
                        
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
                    
        }
        return view('designation');
    }

    
    public function addDesignation(Request $request)
    {
        // dd($request->designation_name);
        $Designation = new Designation;
        $Designation->designation_name = $request->designation_name;
        $Designation->salary = $request->salary;
        $Designation->status = 0;
        $Designation->save();

        if ($Designation->id) {
            return response()->json(['success' => 'Added successfully.']);
        } else {
            return response()->json(['failed' => 'Added failed.']);
        }
    }

    public function deleteDesignation($id)
    {
        $Designation = Designation::find($id)->delete();
        // $flight->delete();
        if ($Designation) {
            return response()->json(['success' => 'Delete successfully !!!']);
        } else {
            return response()->json(['falied' => 'Delete falied !!!']);
        }
    }

    
}

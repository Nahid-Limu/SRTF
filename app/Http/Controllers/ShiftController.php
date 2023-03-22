<?php

namespace App\Http\Controllers;

use App\Shift;
use Illuminate\Http\Request;
use DB;

class ShiftController extends Controller
{
    public function index()
    {
        
        // $Shift = Shift::first();
        // $time =  ( date( "H:i", strtotime("00:00") + strtotime($Shift->exit_time) - strtotime($Shift->entry_time) ) );
        // $f =  ( date( "H:i", strtotime("00:00") + strtotime($time) - strtotime($Shift->break_time) ) );
        // dd( $f);

        $Shift = Shift::all();
        if(request()->ajax())
        {
            return datatables()->of($Shift)
                    
                    ->addColumn('action', function($data){
                        $button = '<button type="button" onclick="deleteModal('.$data->id.',\''.$data->designation_name.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-sm" data-toggle="modal" data-target="#DeleteConfirmationModal" data-placement="top" title="Delete"  style="color: red"><i class="fa fa-trash"> Delete</i></button></div>';
                        
                        return $button;
                    })
                    ->editColumn('entry_time', function ($Shift) {
                        return date('h:i A', strtotime($Shift->entry_time));
                    })
                    ->editColumn('exit_time', function ($Shift) {
                        return date('h:i A', strtotime($Shift->exit_time));
                    })
                    ->editColumn('break_time', function ($Shift) {
                        return date('h:i', strtotime($Shift->break_time))." Hr";
                    })

                    ->addColumn('work_time', function($data){
                        return ( date( "H:i", strtotime("00:00") + strtotime($data->exit_time) - strtotime($data->entry_time) - strtotime($data->break_time)  ) );
                        
                        return $button;
                    })

                    ->rawColumns(['work_time','action'])
                    ->addIndexColumn()
                    ->make(true);
                    
        }
        return view('shift');
    }

    public function addShift(Request $request)
    {
        // dd($request->all());
        $Shift = new Shift;
        $Shift->shift_name = $request->shift_name;
        $Shift->entry_time = date("G:i", strtotime($request->entry_time));
        $Shift->exit_time = date("G:i", strtotime($request->exit_time));
        $Shift->break_time = date("G:i", strtotime($request->break_time));
        $Shift->save();

        if ($Shift->id) {
            return response()->json(['success' => 'Added successfully.']);
        } else {
            return response()->json(['failed' => 'Added failed.']);
        }
    }
}

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
        $Designation = Designation::all();
        $Shift = Shift::all();
        return view('employee', compact( 'Designation', 'Shift' ) );
    }
}

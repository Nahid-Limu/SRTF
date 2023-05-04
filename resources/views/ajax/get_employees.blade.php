<option value="">-- Select Employees --</option>
        <option value="all">All Employee</option>
    @foreach($Employees as $e)
        <option value="{{$e->id}}">{{$e->employee_name}} ->( {{$e->employee_code}} )</option>
    @endforeach
<option value="">-- Select Employees --</option>
    @foreach($Employees as $e)
        <option value="{{$e->id}}">{{$e->employee_name}} ->( {{$e->employee_code}} )</option>
    @endforeach
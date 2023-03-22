
<!-- Modal start -->
<div class="modal fade" id="AddEmployeeModal">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInLeft">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true" style="color: red"></i> New Employee</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form id="AddEmployeeForm">  
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="employee_name">Employee</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="text" class="form-control" id="employee_name" name="employee_name" required>
                            <span id="employee_nameError"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="designation">Designation</label>
                        </div>
                        <div class="form-group col-md-8">
                            <select class="form-control" id="designation" name="designation" required>
                                <option >Select One</option>
                                @foreach ($Designation as $d)
                                    <option value="{{$d->id}}">{{$d->designation_name}}</option>
                                @endforeach
                            </select>
                            <span id="designationError"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="shift">Shift</label>
                        </div>
                        <div class="form-group col-md-8">
                            <select class="form-control" id="shift" name="shift" required>
                                <option >Select One</option>
                                @foreach ($Shift as $s)
                                    <option value="{{$s->id}}">{{$s->shift_name}}</option>
                                @endforeach
                            </select>
                            <span id="shiftError"></span>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Modal footer  class="modal-footer"-->
            <div class="modal-footer" style="display: inline">
                <button onclick="addShift()" type="button" class="btn btn-success float-right">Add</button>
                <button onclick="onCloseModal('AddShiftForm')" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                {{-- <button onclick="testfun()" type="button" class="btn btn-danger">test</button> --}}
            </div>

        </div>
    </div>
</div>
<!-- Modal end -->
<script>

</script>
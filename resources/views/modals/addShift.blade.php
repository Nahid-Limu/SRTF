
<!-- Modal start -->
<div class="modal fade" id="AddShiftModal">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInLeft">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true" style="color: red"></i> New Shift</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form id="AddShiftForm">  
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="shift_name">Shift</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="text" class="form-control" id="shift_name" name="shift_name" required>
                            <span id="shift_nameError"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="entry_time">Entry Time</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="time" class="form-control" id="entry_time" name="entry_time" required>
                            <span id="entry_timeError"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="exit_time">Exit Time</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="time" class="form-control" id="exit_time" name="exit_time" required>
                            <span id="exit_timeError"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="break_time">Break Time</label>
                        </div>
                        <div class="form-group col-md-8">
                            {{-- <input type="time" class="form-control" id="break_time" name="break_time" required>
                            <span id="break_timeError"></span> --}}
                            <select class="form-control" id="break_time" name="break_time" required>
                                <option >Select Break Hour</option>
                                <option value="1:00">1:00 Hour</option>
                                <option value="1:30">1:30 Hour</option>
                                <option value="2:00">2:00 Hour</option>
                                <option value="2:30">2:30 Hour</option>
                            </select>
                            <span id="break_timeError"></span>
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
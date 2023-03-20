
<!-- Modal start -->
<div class="modal fade" id="AddDesignationModal">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInLeft">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true" style="color: red"></i> New Designation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form id="AddDesignationForm">  
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="designation_name">Designation</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="text" class="form-control" id="designation_name" name="designation_name" required>
                            <span id="designation_nameError"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="form-control" for="salary">Salary BDT/hr</label>
                        </div>
                        <div class="form-group col-md-8">
                            <input type="number" class="form-control" id="salary" name="salary" required>
                            <span id="salaryError"></span>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Modal footer  class="modal-footer"-->
            <div class="modal-footer" style="display: inline">
                <button onclick="addDesignation()" type="button" class="btn btn-success float-right">Add</button>
                <button onclick="onCloseModal('AddDesignationForm')" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                {{-- <button onclick="testfun()" type="button" class="btn btn-danger">test</button> --}}
            </div>

        </div>
    </div>
</div>
<!-- Modal end -->
<script>

</script>
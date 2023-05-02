@extends('layouts.app')
@section('title', 'Report')
@section('content')
<div class="col-xl-12 col-lg-8">
            
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-center">

        <h6 class="m-0 font-weight-bold text-primary text-center"><i class="fas fa-list"> Attendance Report</i></h6>
      </div>

      <form action=" {{route('report')}} " method="get">
        @csrf
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          
            <div class="dropdown no-arrow">
              
                <div class="dropdown no-arrow">
                  <label for="from_datepicker" >Employee List</label>
                </div>

                <div class="input-group">
                  <select id="employee_id" name="employee_id"  class="form-control">
                    <option value="">Select Employee</option>
                  </select>
                </div>
                
            </div>

            <div class="dropdown no-arrow">

              <div class="dropdown no-arrow">
                <label for="from_datepicker" >From :</label>
              </div>

              <div class="dropdown no-arrow">
                <input type="date" onchange="EnableToDate()" id="from_datepicker" name="from" class="form-control" autocomplete="off">
              </div>

            </div>

            <div class="dropdown no-arrow">

              <div class="dropdown no-arrow">
                <label for="to_datepicker" >To :</label>
              </div>

              <div class="dropdown no-arrow">
                <input type="date" id="to_datepicker" name="to" class="form-control" autocomplete="off" disabled >
              </div>
              
            </div>

            <div class="dropdown no-arrow">
              <button type="submit" class="btn btn-sm btn-info"><i class="fas fa-eye fa-fw mr-2 text-gray-400"></i>Generate</button>
            </div>
          

        </div>
      </form>
      <!-- Card Body -->
      <div class="card-body">
        <table id="DesignationListTable" class="table table-striped table-bordered">
          <thead>
              <tr>
                  <th class="text-center">#NO</th>
                  <th class="text-center">Designation</th>
                  <th class="text-center">Salary BDT/hr</th>
                  <th class="text-center">Action</th>
              </tr>
          </thead>
  
      </table>
      </div>
    </div>
</div>

<!--Modals-->
@include('modals.addDesignation')
<!--Modals-->
@endsection

@section('script')
{{-- <script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js" ></script> --}}
<script>

  $( document ).ready(function() {
      //get Employee start
      $.ajax({
          url:"{{route('ajax.all_employees')}}",
          method:"get",
          success:function (response) {
              //console.log(response);
              $('#employee_id').html(response);
              // $('.leave_info').hide();
              // $("#assign_btn").prop('disabled', true);
          }
      });
      //get Employee end
  });

  $("#employee_id").select2({
      placeholder: "Select Employees"
  });

  function EnableToDate() {
  if ($("#from_datepicker" ).val()) {
      $("#to_datepicker" ).prop('disabled', false);
  }
}
 
  $('#DesignationListTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        "order": [[ 0, "asc" ]],
        ajax:{
          url: "{{ route('designation') }}",
        },
        columns:[
          { 
              data: 'DT_RowIndex', 
              name: 'DT_RowIndex' 
          },
          
          {
              data: 'designation_name',
              name: 'designation_name'
          },
          {
              data: 'salary',
              name: 'salary'
          },
          {
              data: 'action',
              name: 'action',
              orderable: false
          }
        ]
  });


  


  


 
</script>

@endsection

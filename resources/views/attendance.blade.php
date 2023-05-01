@extends('layouts.app')
@section('title', 'Attendance')
@section('content')
<div class="col-xl-12 col-lg-8">
            
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list"> Employee Attendance LIST</i></h6>
        <strong id="success_message" class="text-success"></strong>
        
        <div class="dropdown no-arrow">
          {{-- <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#AddAttendanceModal"><i class="fas fa-plus fa-fw mr-2 text-gray-400"></i>Add New</button> --}}
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <table id="AttendanceListTable" class="table table-striped table-bordered">
          <thead>
              <tr>
                  <th class="text-center">#NO</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">E-Code</th>
                  <th class="text-center">Shif</th>
                  <th class="text-center">check In</th>
                  <th class="text-center">Break</th>
                  <th class="text-center">Lunch </th>
                  <th class="text-center">check Out</th>
                  {{-- <th class="text-center">Action</th> --}}
              </tr>
          </thead>
  
      </table>
      </div>
    </div>
</div>

<!--Modals-->
{{-- @include('modals.addAttendance') --}}
<!--Modals-->
@endsection

@section('script')
{{-- <script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js" ></script> --}}
<script>
 
 $('#AttendanceListTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      "order": [[ 0, "asc" ]],
      ajax:{
        url: "{{ route('attendance') }}",
      },
      columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        
        {
            data: 'employee_name',
            name: 'employee_name'
        },
        {
            data: 'employee_code',
            name: 'employee_code'
        },
        {
            data: 'shift',
            name: 'shift'
        },
        {
            data: 'checkIn',
            name: 'checkIn'
        },
        {
            data: 'breakfast',
            name: 'breakfast'
        },
        {
            data: 'lunch',
            name: 'lunch'
        },
        {
            data: 'checkOut',
            name: 'checkOut'
        },
        
        // {
        //     data: 'action',
        //     name: 'action',
        //     orderable: false
        // }
      ]
});


 function checkInOut(emp_id,check,shiftsId) {
    //  alert(emp_id+"/"+check+"/"+shiftsId);
     $.ajax({
        type: 'GET',
        url: "{{url('checkInOut')}}"+"/"+emp_id+"/"+check+"/"+shiftsId,
         
         success: function (response) {
             console.log(response);
             if (response.success) {
                     
               $("#success_message").text(response.success);
               $('#AttendanceListTable').DataTable().ajax.reload();
            //    $('#DeleteConfirmationModal').modal('hide');

               SuccessMsg();
             }

         },error:function(){ 
             console.log(response);
         }
     });
 }


 function breakOnOff(emp_id,breakfast) {
    //  alert(emp_id);
     $.ajax({
        type: 'GET',
        url: "{{url('breakFast')}}"+"/"+emp_id+"/"+breakfast,
         
         success: function (response) {
             console.log(response);
             if (response.success) {
                     
                $("#success_message").text(response.success);
                $('#AttendanceListTable').DataTable().ajax.reload();
                // $('#DeleteConfirmationModal').modal('hide');

               SuccessMsg();
             }

         },error:function(){ 
             console.log(response);
         }
     });
 }

 function lunchOnOff(emp_id,lunch) {
    //  alert(lunch);
     $.ajax({
        type: 'GET',
        url: "{{url('lunch')}}"+"/"+emp_id+"/"+lunch,
         
         success: function (response) {
             console.log(response);
             if (response.success) {
                     
                $("#success_message").text(response.success);
                $('#AttendanceListTable').DataTable().ajax.reload();
                // $('#DeleteConfirmationModal').modal('hide');

               SuccessMsg();
             }

         },error:function(){ 
             console.log(response);
         }
     });
 }
 
</script>

@endsection

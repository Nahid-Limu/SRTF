@extends('layouts.app')
@section('title', 'Employee Settings')
@section('content')
<div class="col-xl-12 col-lg-8">
            
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list"> Employee LIST</i></h6>
        <strong id="success_message" class="text-success"></strong>
        
        <div class="dropdown no-arrow">
          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#AddEmployeeModal"><i class="fas fa-plus fa-fw mr-2 text-gray-400"></i>Add New</button>
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <table id="EmployeeListTable" class="table table-striped table-bordered">
          <thead>
              <tr>
                  {{-- <th class="text-center">#NO</th> --}}
                  <th class="text-center">Shift</th>
                  <th class="text-center">Entry</th>
                  <th class="text-center">Exit</th>
                  <th class="text-center">Break</th>
                  <th class="text-center">Work Time</th>
                  <th class="text-center">Action</th>
              </tr>
          </thead>
  
      </table>
      </div>
    </div>
</div>

<!--Modals-->
@include('modals.addEmployee')
<!--Modals-->
@endsection

@section('script')
{{-- <script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js" ></script> --}}
<script>
 
 $('#ShiftListTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      "order": [[ 0, "asc" ]],
      ajax:{
        url: "{{ route('shift') }}",
      },
      columns:[
        // { 
        //     data: 'DT_RowIndex', 
        //     name: 'DT_RowIndex' 
        // },
        
        {
            data: 'shift_name',
            name: 'shift_name'
        },
        {
            data: 'entry_time',
            name: 'entry_time'
        },
        {
            data: 'exit_time',
            name: 'exit_time'
        },
        {
            data: 'break_time',
            name: 'break_time'
        },
        {
            data: 'work_time',
            name: 'work_time'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
      ]
});

 function addShift() {
       if ( $( "#shift_name" ).val() != '' ) {
           $("#shift_name").removeClass("errorInputBox");
           $( "#shift_nameError").text('').removeClass("ErrorMsg");
           
       } else {
           $("#shift_name").addClass("errorInputBox");
           $( "#shift_nameError").text('Shift Is Required').addClass("ErrorMsg");
       }

       if ( $( "#entry_time" ).val() != '' ) {
           $("#entry_time").removeClass("errorInputBox");
           $( "#entry_timeError").text('').removeClass("ErrorMsg");
           
       } else {
           $("#entry_time").addClass("errorInputBox");
           $( "#entry_timeError").text('Entry Time Is Required').addClass("ErrorMsg");
       }

       if ( $( "#exit_time" ).val() != '' ) {
           $("#exit_time").removeClass("errorInputBox");
           $( "#exit_timeError").text('').removeClass("ErrorMsg");
           
       } else {
           $("#exit_time").addClass("errorInputBox");
           $( "#exit_timeError").text('Exit Time Is Required').addClass("ErrorMsg");
       }

       if ( $( "#break_time" ).val() != '' ) {
           $("#break_time").removeClass("errorInputBox");
           $( "#break_timeError").text('').removeClass("ErrorMsg");
           
       } else {
           $("#break_time").addClass("errorInputBox");
           $( "#break_timeError").text('Break Time Is Required').addClass("ErrorMsg");
       }

       if ( $( "#shift_name" ).val() && $( "#entry_time" ).val() && $( "#exit_time" ).val() && $( "#break_time" ).val() ) {
           $( "#shift_nameError,#entry_timeError,#exit_timeError,#break_timeError").text('');
           $( "#shift_name,#entry_time,#exit_time,#break_time").removeClass("errorInputBox");
         
           var myData =  $('#AddShiftForm').serialize();
           // alert(myData);
           $.ajax({
               type: 'POST', //THIS NEEDS TO BE GET
               url: "{{ route('addShift') }}",
               // data: {_token: _token, clintName: clintName,age: age,sex: sex,address: address,ref_dr: ref_dr},
               // data: {_token: _token, myData: myData},
               data: myData,
               // dataType: 'json',
               success: function (response) {
                   console.log(response);
                   if (response.success) {
                     
                     $("#success_message").text(response.success);
                     $('#ShiftListTable').DataTable().ajax.reload();
                     $('#AddShiftModal').modal('hide');
                     $("#AddShiftForm").trigger("reset");
                     
                     SuccessMsg();
                   }

               },error:function(){ 
                   console.log(response);
               }
           });
       }
 }

 function deleteTableData(id) {
     // alert(TestId);
     $.ajax({
        type: 'GET',
        url: "{{url('deleteDesignation')}}"+"/"+id,
         
         success: function (response) {
             console.log(response);
             if (response.success) {
                     
               $("#success_message").text(response.success);
               $('#DesignationListTable').DataTable().ajax.reload();
               $('#DeleteConfirmationModal').modal('hide');

               SuccessMsg();
             }

         },error:function(){ 
             console.log(response);
         }
     });
 }
 
</script>

@endsection

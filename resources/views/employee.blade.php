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
                  <th class="text-center">#NO</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Code</th>
                  <th class="text-center">Phone</th>
                  <th class="text-center">Designation</th>
                  <th class="text-center">Time</th>
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
 
 $('#EmployeeListTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      "order": [[ 0, "asc" ]],
      ajax:{
        url: "{{ route('employee') }}",
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
            data: 'employee_phone',
            name: 'employee_phone'
        },
        {
            data: 'designation',
            name: 'designation'
        },
        {
            data: 'time',
            name: 'time'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
      ]
});

 function addEmployee() {
       if ( $( "#employee_name" ).val() != '' ) {
           $("#employee_name").removeClass("errorInputBox");
           $( "#employee_nameError").text('').removeClass("ErrorMsg");
           
       } else {
           $("#employee_name").addClass("errorInputBox");
           $( "#employee_nameError").text('Employee_name Is Required').addClass("ErrorMsg");
       }

       if ( $( "#employee_phone" ).val() != '' ) {
           $("#employee_phone").removeClass("errorInputBox");
           $( "#employee_phoneError").text('').removeClass("ErrorMsg");
           
       } else {
           $("#employee_phone").addClass("errorInputBox");
           $( "#employee_phoneError").text('Phone Number Is Required').addClass("ErrorMsg");
       }

       if ( $( "#designation_id" ).val() != '' ) {
           $("#designation_id").removeClass("errorInputBox");
           $( "#designation_idError").text('').removeClass("ErrorMsg");
           
       } else {
           $("#designation_id").addClass("errorInputBox");
           $( "#designation_idError").text('Designation Is Required').addClass("ErrorMsg");
       }

       if ( $( "#shift_id" ).val() != '' ) {
           $("#shift_id").removeClass("errorInputBox");
           $( "#shift_idError").text('').removeClass("ErrorMsg");
           
       } else {
           $("#shift_id").addClass("errorInputBox");
           $( "#shift_idError").text('Shift Is Required').addClass("ErrorMsg");
       }
       
       if ( $( "#employee_name" ).val() && $( "#employee_phone" ).val() && $( "#designation_id" ).val() && $( "#shift_id" ).val()  ) {

           $( "#employee_nameError,#employee_phoneError,#ddesignation_idError,#shift_idError").text('');
           $( "#employee_name,#employee_phone,#ddesignation_id,#shift_id").removeClass("errorInputBox");
           var myData =  $('#AddEmployeeForm').serialize();
        //    alert(myData);
           $.ajax({
               type: 'POST', //THIS NEEDS TO BE GET
               url: "{{ route('addEmployee') }}",
               // data: {_token: _token, clintName: clintName,age: age,sex: sex,address: address,ref_dr: ref_dr},
               // data: {_token: _token, myData: myData},
               data: myData,
               // dataType: 'json',
               success: function (response) {
                   console.log(response);
                   if (response.success) {
                     
                     $("#success_message").text(response.success);
                     $('#EmployeeListTable').DataTable().ajax.reload();
                     $('#AddEmployeeModal').modal('hide');
                     $("#AddEmployeeForm").trigger("reset");
                     
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

@extends('layouts.app')
@section('title', 'Designation Settings')
@section('content')
<div class="col-xl-12 col-lg-8">
            
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list"> Designation LIST</i></h6>
        <strong id="success_message" class="text-success"></strong>
        
        <div class="dropdown no-arrow">
          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#AddDesignationModal"><i class="fas fa-plus fa-fw mr-2 text-gray-400"></i>Add New</button>
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <table id="DesignationListTable" class="table table-striped table-bordered">
          <thead>
              <tr>
                  <th class="text-center">#NO</th>
                  <th class="text-center">Designation</th>
                  <th class="text-center">Salary</th>
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

 function addDesignation() {
       if ( $( "#designation_name" ).val() != '' ) {
           $("#designation_name").removeClass("errorInputBox");
           $( "#designation_nameError").text('').removeClass("ErrorMsg");
           
       } else {
           $("#designation_name").addClass("errorInputBox");
           $( "#designation_nameError").text('Designation Is Required').addClass("ErrorMsg");
       }

       if ( $( "#salary" ).val() != '' ) {
           $("#salary").removeClass("errorInputBox");
           $( "#salaryError").text('').removeClass("ErrorMsg");
           
       } else {
           $("#salary").addClass("errorInputBox");
           $( "#salaryError").text('Salary Is Required').addClass("ErrorMsg");
       }

       if ( $( "#designation_name" ).val() && $( "#salary" ).val() ) {
           $( "#salaryError,#designation_nameError").text('');
           $( "#salary,#designation_name").removeClass("errorInputBox");
         
           var myData =  $('#AddDesignationForm').serialize();
           // alert(myData);
           $.ajax({
               type: 'POST', //THIS NEEDS TO BE GET
               url: "{{ route('addDesignation') }}",
               // data: {_token: _token, clintName: clintName,age: age,sex: sex,address: address,ref_dr: ref_dr},
               // data: {_token: _token, myData: myData},
               data: myData,
               // dataType: 'json',
               success: function (response) {
                   console.log(response);
                   if (response.success) {
                     
                     $("#success_message").text(response.success);
                     $('#DesignationListTable').DataTable().ajax.reload();
                     $('#AddDesignationModal').modal('hide');
                     $("#AddDesignationForm").trigger("reset");
                     
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

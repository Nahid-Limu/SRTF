@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="col-xl-12 col-lg-8">


    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard <hr></h1>
            
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    TOTAL EMPLOYEE</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ToatalEmployee }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    EMPLOYEE TYPE</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ToatalDesignation }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-retweet fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    TOTAL SHIFT</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ToatalShift }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-redo-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    TOTAL WORKING HOUR</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $WorkHour[0]->total_work_time }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calculator fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        {{-- <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="myPieChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-primary"></i> Direct
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> Social
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-info"></i> Referral
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Content Row -->
        
        {{-- <div class="row">

            <!-- Content Column -->
            <div class="col-lg-6 mb-4">

                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                    </div>
                    <div class="card-body">
                        <h4 class="small font-weight-bold">Server Migration <span
                                class="float-right">20%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"
                                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h4 class="small font-weight-bold">Sales Tracking <span
                                class="float-right">40%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h4 class="small font-weight-bold">Customer Database <span
                                class="float-right">60%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar" role="progressbar" style="width: 60%"
                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h4 class="small font-weight-bold">Payout Details <span
                                class="float-right">80%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 80%"
                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h4 class="small font-weight-bold">Account Setup <span
                                class="float-right">Complete!</span></h4>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                <!-- Color System -->
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-primary text-white shadow">
                            <div class="card-body">
                                Primary
                                <div class="text-white-50 small">#4e73df</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-success text-white shadow">
                            <div class="card-body">
                                Success
                                <div class="text-white-50 small">#1cc88a</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-info text-white shadow">
                            <div class="card-body">
                                Info
                                <div class="text-white-50 small">#36b9cc</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-warning text-white shadow">
                            <div class="card-body">
                                Warning
                                <div class="text-white-50 small">#f6c23e</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-danger text-white shadow">
                            <div class="card-body">
                                Danger
                                <div class="text-white-50 small">#e74a3b</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-secondary text-white shadow">
                            <div class="card-body">
                                Secondary
                                <div class="text-white-50 small">#858796</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-light text-black shadow">
                            <div class="card-body">
                                Light
                                <div class="text-black-50 small">#f8f9fc</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card bg-dark text-white shadow">
                            <div class="card-body">
                                Dark
                                <div class="text-white-50 small">#5a5c69</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-6 mb-4">

                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                src="img/undraw_posting_photo.svg" alt="...">
                        </div>
                        <p>Add some quality, svg illustrations to your project courtesy of <a
                                target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a
                            constantly updated collection of beautiful svg images that you can use
                            completely free and without attribution!</p>
                        <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                            unDraw &rarr;</a>
                    </div>
                </div>

                <!-- Approach -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                    </div>
                    <div class="card-body">
                        <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                            CSS bloat and poor page performance. Custom CSS classes are used to create
                            custom components and custom utility classes.</p>
                        <p class="mb-0">Before working with this theme, you should become familiar with the
                            Bootstrap framework, especially the utility classes.</p>
                    </div>
                </div>

            </div>
        </div> --}}

    </div>

</div>

<!--Modals-->
@include('modals.addShift')
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

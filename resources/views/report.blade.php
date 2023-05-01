@extends('layouts.app')
@section('title', 'Report')
@section('content')
<div class="col-xl-12 col-lg-8">
            
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list"> Attendance Report</i></h6>

        
        <div class="dropdown no-arrow">
          
            <div class="input-group">
                <input type="text" class="form-control" name="search" id="search" placeholder="Search Employee">
                <div class="input-group-append">
                  <button class="btn btn-secondary" type="button">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
            
        </div>
        <div class="dropdown no-arrow">
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#AddDesignationModal"><i class="fas fa-plus fa-fw mr-2 text-gray-400"></i>Add New</button>
        </div>
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

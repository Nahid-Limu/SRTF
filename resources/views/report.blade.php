@extends('layouts.app')
@section('title', 'Report')
@section('content')
<div class="col-xl-12 col-lg-8">
            
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-center">

        <h6 class="m-0 font-weight-bold text-primary text-center"><i class="fas fa-list"> Employee Report Details</i></h6>
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
              <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-eye fa-fw mr-2 text-gray-400"></i>Report Generate</button>
            </div>
            {{-- <div class="dropdown no-arrow">
              <button type="submit" class="btn btn-sm btn-info" name="btnExport" value="csv"><i class="fas fa-eye fa-fw mr-2 text-gray-400"></i>Export Report</button>
            </div> --}}
          

        </div>
      </form>

      {{-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-center">
        @isset($dates)
          <h6 class="m-0 font-weight-bold text-danger ">Employee Report From: <kbd>{{ $dates['from'] }}</kbd> To: <kbd>{{ $dates['to'] }}</kbd></h6> 
        @endisset
      </div> --}}
      <!-- Card Body -->
      <div class="card-body">
        @isset($ReportData)
        <div id="printableTable">
          <div id="company_details" class="card-header py-3 d-flex flex-row align-items-center justify-content-center">
              <span style="text-align: center" class="text-warning"><i class="fa fa-puzzle-piece" aria-hidden="true"></i> <b style="color: green">Sazeda RafiquenTea Factory Ltd.</b> <i class="fa fa-puzzle-piece" aria-hidden="true"></i> <br><i style="color: gray">Moulovipara, Jagdol, Panchagarh.</i> <br> <hr><hr> </span>   
          </div>
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-center">
            @isset($dates)
              <h6 class="m-0 font-weight-bold text-danger ">Employee Report From: <kbd>{{ $dates['from'] }}</kbd> To: <kbd>{{ $dates['to'] }}</kbd></h6> 
            @endisset
          </div>
        <table id="DesignationListTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    {{-- <th class="text-center">#NO</th> --}}
                    <th class="text-center">Name</th>
                    <th class="text-center">ID No</th>
                    <th class="text-center">Break Hour</th>
                    <th class="text-center">Working Hour</th>
                    <th class="text-center">Salary BDT/hr</th>
                    <th class="text-center">Salary</th>
                    {{-- <th class="text-center">Salary BDT/hr</th> --}}
                    {{-- <th class="text-center">Action</th> --}}
                </tr>
            </thead>
            <tbody>
              @foreach ($ReportData as $Report)
                  <tr>
                    {{-- <td>{{ $no++ }}</td> --}}
                    <td>{{ $Report->employee_name }}</td>
                    <td>{{ $Report->employee_code }}</td>
                    <td>{{ $Report->total_break }} Hr</td>
                    <td>{{ $Report->work_time }} Hr</td>
                    <td>{{ $Report->salary }} Bdt</td>
                    <td>{{ $Report->total_salary }} Bdt</td>
                    
                  </tr>
              @endforeach
            </tbody>
        </table>
      </div>
      <iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
      <form action="{{route('report')}}" method="get">
        @csrf
        <input type="hidden" name="btnExport" value="csv">
        <input type="hidden" name="employee_id" value="{{ $employee_id }}">
        <input type="hidden" name="exp_from" value="{{ $dates['from'] }}">
        <input type="hidden" name="exp_to" value="{{ $dates['to'] }}">
        <button class="btn btn-sm btn-info float-left" type="submit"><i class="fas fa-file-csv"> Export Report</i></button>
      </form>
      <button class="btn btn-sm btn-warning float-right" onclick="printDiv('printableTable')"><i class="fas fa-print"> Print</i></button>
        @endisset
        
      </div>
    </div>
</div>

<!--Modals-->
@include('modals.addDesignation')
<!--Modals-->
@endsection

@section('script')
{{-- <script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js" ></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"
    integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous">
</script>
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
 
</script>
<script>
  //print Div//
  // function printDiv(divName) {
  //     var printContents = document.getElementById(divName).innerHTML;
  //     var originalContents = document.body.innerHTML;

  //     document.body.innerHTML = printContents;

  //     window.print();

  //     document.body.innerHTML = originalContents;

  //     // window.location.href = "{{ route('report') }}";
  // }

  function printDiv(divName) {
        // $('#company_details').prop('visible', true);
        // document.getElementById("company_details")[0].style.display = 'none';
         window.frames["print_frame"].document.body.innerHTML = document.getElementById(divName).innerHTML;
         window.frames["print_frame"].window.focus();
         window.frames["print_frame"].window.print();
       }

  //print Div//
</script>
<script>
  // here we will write our custom code for printing our div
  $(function(){
    var doc = new jsPDF();
          var specialElementHandlers = {
              '#editor': function (element, renderer) {
                  return true;
              }
          };

          $('#exportPDF').click(function () {
              doc.fromHTML($('#printableArea').html(), 15, 15, {
                  'width': 170,
                      'elementHandlers': specialElementHandlers
              });
              doc.save('INVOICE-'+this.value+'.pdf');
          });
  });
</script>

@endsection

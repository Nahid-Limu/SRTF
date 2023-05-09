<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'DSMS') }}</title> --}}
    <link rel="icon" type="image/png" href="{!! asset('system_img/icon.ico') !!}"/>
    <title> @yield('title')</title>

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    {{-- <script src="{{ asset('js/app.js') }}" ></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .ErrorMsg {
                  color: red;
        }
  
        .SuccessMsg {
                  color: green;
        }
    
        .errorInputBox {
            border: 1px solid red !important;
        }
  
        .successInputBox {
            border: 1px solid green !important;
        }
      </style>

    
        @include('include.css')

</head>
<body id="page-top">

    <div id="wrapper">
  
        <!-- Sidebar Content -->
        @include('include.sidebar')
        <!-- Sidebar Content end hare-->
  
      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
  
        <!-- Main Content -->
        <div id="content">
          @include('include.nav')
            @yield('content')
            
        </div>
        <!-- End of Main Content -->
  
        <!-- Footer -->
        @include('include.footer')
        <!-- End of Footer -->
  
      </div>
      <!-- End of Content Wrapper -->
  
    </div>
    <!-- End of Page Wrapper -->
  
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal-->
    <div class="modal fade" id="DeleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Delete?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">Select "Delete" below if you are <strong>Sure</strong> to <strong>Delete</strong> this <strong id="dtn"></strong> Record</div>
            <div class="modal-footer" style="display: inline">
            <input type="hidden" id="delete_data_id" value="">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <button onclick="deleteTableData($('#delete_data_id').val())" class="btn btn-danger float-right" type="button">Delete</button>
            </div>
        </div>
        </div>
    </div>

    

</body>

  
    @include('include.js')
    @yield('script')

</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Invoice-Management') }}</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('assets/Backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('assets/Backend/css/sb-admin-2.min.css') }}" rel="stylesheet">
  <!-- select2 min css -->
  <link href="{{ asset('assets/Backend/select2/css/select2.min.css') }}" rel="stylesheet">
  <!--- extra page source ----->
  @stack('css')
</head>

<body id="page-top">
      
      @include('layouts.Backend.partials.sidebar')
      @include('layouts.Backend.partials.topnavigation')

      <!-- Errors -->
      <!-- <div class="container-fluid status-block"> -->
        <!-- <div class="card-body"> -->
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
        <!-- </div> -->
      <!-- </div> -->
      <!-- Begin Page Content -->
        <div class="container-fluid">
            @yield('content')
       </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; TechMonstre 2021</span>
          </div>
        </div>
      </footer>
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
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <a class="btn btn-primary" href="{{ route('logout') }}"
          onclick="event.preventDefault();
           document.getElementById('logout-form').submit();"
          >
          Logout
                                      
          </a>
           <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('assets/Backend/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/Backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('assets/Backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('assets/Backend/js/sb-admin-2.min.js') }}"></script>

  <!-- Page level plugins -->
  <script src="{{ asset('assets/Backend/vendor/chart.js/Chart.min.js') }}"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('assets/Backend/js/demo/chart-area-demo.js') }}"></script>
  <script src="{{ asset('assets/Backend/js/demo/chart-pie-demo.js') }}"></script>
  <script src="{{ asset('assets/Backend/js/handlebars.min.js') }}"></script>
  <!--- Notify js Start --->
  <script src="{{ asset('assets/Backend/js/notify.js') }}"></script>
  <!-- Select2 js -->
  <script src="{{ asset('assets/Backend/select2/js/select2.min.js') }}"></script>
  @stack('js')
  @stack('ajax')

  <!---- Success Message -->
  @if(session()->has('success'))
    <script type="text/javascript">
      $(function(){
        $.notify("{{ session()->get('success') }}",{globalPosition:'top right',className:'success'});
      });
    </script>
  @endif
  <!---- Error Message -->
  @if(session()->has('error'))
    <script type="text/javascript">
      $(function(){
        $.notify("{{ session()->get('error') }}",{globalPosition:'top right',className:'error'});
      });
    </script>
  @endif
<!--- Notify js End --->
<!---- Select2 ---->
<script type="text/javascript">
  $(document).ready(function(){
     $(".select2").select2();
  });
</script>

<!-- datatables export excel,pdf -->
<script type="text/javascript">
  function newexportaction(e, dt, button, config) {
  var self = this;
  var oldStart = dt.settings()[0]._iDisplayStart;
  dt.one('preXhr', function (e, s, data) {
  // Just this once, load all data from the server...
  data.start = 0;
  data.length = 2147483647;
  dt.one('preDraw', function (e, settings) {
  // Call the original action function
  if (button[0].className.indexOf('buttons-copy') >= 0) {
  $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
  } else if (button[0].className.indexOf('buttons-excel') >= 0) {
  $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
  $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
  $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
  } else if (button[0].className.indexOf('buttons-csv') >= 0) {
  $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
  $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
  $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
  } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
  $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
  $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
  $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
  } else if (button[0].className.indexOf('buttons-print') >= 0) {
  $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
  }
  dt.one('preXhr', function (e, s, data) {
  // DataTables thinks the first item displayed is index 0, but we're not drawing that.
  // Set the property to what it was before exporting.
  settings._iDisplayStart = oldStart;
  data.start = oldStart;
  });
  // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
  setTimeout(dt.ajax.reload, 0);
  // Prevent rendering of the full data to the DOM
  return false;
  });
  });
  // Requery the server with the new one-time export settings
  dt.ajax.reload();
}
</script>
@yield('js')
</body>

</html>

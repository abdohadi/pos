<!DOCTYPE html>
<html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/bootstrap3.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/font-awesome/css/font-awesome.min.css') }}">
  <!-- Theme style -->
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/skin-blue.min.css') }}">
  {{-- 
  <!-- Ionicons -->
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/ionicons/css/ionicons.min.css') }}">
  <!-- Morris chart -->
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/morris.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/jquery-jvectormap.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/bootstrap-datepicker.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/daterangepicker.css') }}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/bootstrap3-wysihtml5.min.css') }}">
 --}}

  @if (app()->getLocale() == 'ar')
    <link rel="stylesheet" href="{{ asset('dashboard/css/Adminlte_rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-rtl.min.css') }}">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">

    <style type="text/css">
      body, h1, h2, h3, h4, h5, h6 {
        font-family: Cairo, sans-serif !important;
      }
    </style>
  @else
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/AdminLTE.min.css') }}">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  @endif

  <style type="text/css">
    .loader {
      border: 16px solid #f3f3f3; /* Light grey */
      border-top: 16px solid #3498db; /* Blue */
      border-radius: 50%;
      width: 120px;
      height: 120px;
      animation: spin 2s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">



  <!-- jQuery 3 -->
  <script type="text/javascript" src="{{ asset('dashboard/js/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script type="text/javascript" src="{{ asset('dashboard/js/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script type="text/javascript">
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.7 -->
  <script type="text/javascript" src="{{ asset('dashboard/js/bootstrap3.min.js') }}"></script>
  {{-- 
  <!-- Morris.js charts -->
  <script type="text/javascript" src="{{ asset('dashboard/js/raphael.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('dashboard/js/morris.min.js') }}"></script>
  <!-- Sparkline -->
  <script type="text/javascript" src="{{ asset('dashboard/js/jquery.sparkline.min.js') }}"></script>
  <!-- jvectormap -->
  <script type="text/javascript" src="{{ asset('dashboard/js/jquery-jvectormap-1.2.2.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('dashboard/js/jquery-jvectormap-world-mill-en.js') }}"></script>
  <!-- jQuery Knob Chart -->
  <script type="text/javascript" src="{{ asset('dashboard/js/jquery.knob.min.js') }}"></script>
  <!-- daterangepicker -->
  <script type="text/javascript" src="{{ asset('dashboard/js/moment.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('dashboard/js/daterangepicker.js') }}"></script>
  <!-- datepicker -->
  <script type="text/javascript" src="{{ asset('dashboard/js/bootstrap-datepicker.min.js') }}"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script type="text/javascript" src="{{ asset('dashboard/js/bootstrap3-wysihtml5.all.min.js') }}"></script>
  <!-- Slimscroll -->
  <script type="text/javascript" src="{{ asset('dashboard/js/jquery.slimscroll.min.js') }}"></script>
  <!-- FastClick -->
  <script type="text/javascript" src="{{ asset('dashboard/js/fastclick.js') }}"></script>
   --}}
  
  <!-- CKEDITOR -->
  <script type="text/javascript" src="{{ asset('dashboard/plugins/ckeditor/ckeditor.js') }}"></script>
  <!-- AdminLTE App -->
  <script type="text/javascript" src="{{ asset('dashboard/js/adminlte.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <!-- printThis -->
  <script type="text/javascript" src="{{ asset('dashboard/js/printThis.js') }}"></script>

  {{-- Custom js --}}
  <script type="text/javascript" src="{{ asset('dashboard/js/custom/order.js') }}"></script>
  <script type="text/javascript" src="{{ asset('dashboard/js/custom/image_preview.js') }}"></script>


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <style type="text/css">
    h1, h2, h3, h4, h5, h6 {
       font-weight: normal;
    }

    .mr-2 {
      margin-right: 5px;
    }
  </style>


</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

  <!-- Header -->
  @include('layouts.dashboard._header')

  <!-- Left side column. contains the logo and sidebar -->
  @include('layouts.dashboard._aside')

  <!-- Partials -->
  @include('partials._session')


  @yield('content')


  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
    reserved.
  </footer>
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark" style="display: none;">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



<script type="text/javascript">

  // delete
  $('.delete').click(function(e) {
    e.preventDefault();

    var n = new Noty({
      text: "@lang('site.confirm_delete')",
      type: "warning",
      killer: true,
      buttons: [
        Noty.button("@lang('site.yes')", 'btn btn-success mr-2', () => {
          $(this).closest('form').submit();
        }),

        Noty.button("@lang('site.no')", 'btn btn-danger mr-2', () => {
          n.close();
        })
      ]
    }).show();
  });


  // ckeditor
  CKEDITOR.config.language = "{{ app()->getLocale() }}";

</script>

</body>
</html>

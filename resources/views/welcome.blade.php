<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{asset('img/a.svg')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="{{asset('css/app.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/paper-dashboard.css?v=2.0.0')}}" rel="stylesheet" />
  <link href="{{asset('css/custom.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
  <!-- loader -->
  <link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />

</head>
<body>
  <div id="app">
      <!-- sidebar -->
    <sidebar></sidebar>

      <div class="main-panel">
     
     <navbar></navbar>


        <div class="content">
          <!-- vue routes will load here -->
          <router-view></router-view>
        </div>
        <footer class="footer footer-black  footer-white ">
          <div class="container-fluid">
            <div class="row">
              <nav class="footer-nav">
                <ul>

                  <li>
                    <router-link to="/app/info" aria-expanded="false">
                      <span>App Info</span>
                    </router-link>
                  </li>
                </ul>
              </nav>
              <div class="credits ml-auto">
                <span class="copyright">
                  ©Made with <i class="fa fa-heart heart"></i> by Prem Lamsal
                </span>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
  </div>
  <!-- loader -->
  <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
  <!-- core app js -->
  <script src="{{asset('js/app.js')}}"></script>
  <!--   Core JS Files   -->
  <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
  <!-- <script src="../assets/js/core/bootstrap.min.js"></script> -->
  <script src="{{asset('assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{asset('assets/js/plugins/bootstrap-notify.js')}}"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('assets/js/paper-dashboard.min.js?v=2.0.0')}}" type="text/javascript"></script>

  <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="{{asset('assets/demo/demo.js')}}"></script>
  <!-- bootstrap select javascript -->
  <!-- <script src="{{asset('js/bootstrap-select.min.js')}}"></script> -->


</body>

</html>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Modernize Free</title>
  <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logos/icon-sipetta.png')}}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}" />

  @yield('custome-css')
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="#" class="text-nowrap logo-img">
            <img src="{{asset('assets/images/logos/sipetta.png')}}" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="/dashboard" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">User</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="/apps/master-user" aria-expanded="false">
                <span>
                  <i class="fas fa-fingerprint"></i>
                </span>
                <span class="hide-menu">Daftar User</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Apps</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="/apps/news-letter" aria-expanded="false">
                <span>
                  <i class="fas fa-camera"></i>
                </span>
                <span class="hide-menu">News Letter</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="/apps/agri-farm" aria-expanded="false">
                <span>
                  <i class="fas fa-seedling"></i>
                </span>
                <span class="hide-menu">Urban Agriculture</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="/apps/agri-disease" aria-expanded="false">
                <span>
                  <i class="fas fa-heartbeat"></i>
                </span>
                <span class="hide-menu">Penyakit Tanaman</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="/apps/disease-indicator" aria-expanded="false">
                <span>
                  <i class="fas fa-stethoscope"></i>
                </span>
                <span class="hide-menu">Gejala Penyakit</span>
              </a>
            </li>
          </ul>
          <div class="unlimited-access hide-menu bg-light-primary position-relative mb-7 mt-5 rounded">
            <div class="d-flex">
              <div class="unlimited-access-title me-3">
                <h6 class="fw-semibold fs-4 mb-6 text-dark w-85">Mobile Apps SiPetta</h6>
                <a href="#" target="_blank" class="btn btn-primary fs-2 fw-semibold lh-sm">Get Apps</a>
              </div>
              <div class="unlimited-access-img">
                <img src="{{asset('assets/images/logos/icon-sipetta.png')}}" alt="" height="100px">
              </div>
            </div>
          </div>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item">
                <div class="nav-link" href="javascript:void(0)">
                  <b>@yield('title')</b>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                  <i class="ti ti-bell-ringing"></i>
                  <div class="notification bg-primary rounded-circle"></div>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">My Account</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">My Task</p>
                    </a>
                    <button></button>
                    <a href="javascript:void(0)" onclick="document.getElementById('logout').submit()" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                    <form action="{{ route('logout') }}" method="post" id="logout">
                    @csrf
                    </form>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        @yield('content')
      </div>

      @yield('loading')
      @yield('alert')
      @yield('modal')
      <div class="modal fade" role="dialog" id="modal_loading" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-body pt-0" style="background-color: #FAFAF8; border-radius: 6px;">
                  <div class="text-center">
                      <img style="border-radius: 4px; height: 140px;" src="{{ asset('assets/images/icons/loader.gif') }}" alt="Loading">
                      <h6 style="position: absolute; bottom: 10%; left: 37%;" class="pb-2">Mohon Tunggu..</h6>
                  </div>
              </div>
          </div>
        </div>
      </div>
  </div>
  @include('scriptjs')
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  {{-- Select2  --}}
  <script type="text/javascript" src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
  {{-- Datatables --}}
  <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
  <script>
    function formatTimestamp(timestamp) {
      if(timestamp == '0000-00-00 00:00:00'){
          return '00-00-0000';
      }

      var date = new Date(timestamp);
      var day = date.getDate();
      var month = date.getMonth() + 1;
      var year = date.getFullYear();
      return day + '-' + month + '-' + year;
    }
    
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>
  @yield('custom-js')
</body>

</html>
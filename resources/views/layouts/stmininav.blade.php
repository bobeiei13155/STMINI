<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>STMINI</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">
  <!-- Bootstrap CSS-->
  <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
  <!-- Font Awesome CSS-->
  <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}">
  <!-- Fontastic Custom icon font-->
  <link rel="stylesheet" href="{{asset('css/fontastic.css')}}">
  <!-- Google fonts - Roboto -->
  <link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700')}}">
  <!-- jQuery Circle-->
  <link rel="stylesheet" href="{{asset('css/grasp_mobile_progress_circle-1.0.0.min.css')}}">
  <!-- Custom Scrollbar-->
  <link rel="stylesheet" href="{{asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
  <!-- theme stylesheet-->
  <link rel="stylesheet" href="{{asset('css/style.default.css')}}" id="theme-stylesheet">
  <!-- Custom stylesheet - for your changes-->
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">
  <!-- datatablelink -->

  <link rel="stylesheet" href="{{asset('https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css')}}">

  <!-- Favicon-->
  <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <!-- Tweaks for older IEs-->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  <script src="https://kit.fontawesome.com/5c27faf919.js" crossorigin="anonymous"></script>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
  <!-- Side Navbar -->
  <nav class="side-navbar">
    <div class="side-navbar-wrapper">
      <!-- Sidebar Header    -->
      <div class="sidenav-header d-flex align-items-center justify-content-center">
        <!-- User Info-->
        <div class="sidenav-header-inner text-center"><img src="{{asset('storage')}}/Emp_image/{{session()->get('Img_Emp')}}" alt="person" class="img-fluid rounded-circle">
          <h2 class="h5">{{session()->get('fname')}} {{session()->get('lname')}}</h2>
        </div>
        <!-- Small Brand information, appears on minimized sidebar-->
        <div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"> <strong>S</strong><strong class="text-light">T</strong></a></div>
      </div>
      <!-- Sidebar Navigation Menus-->
      <div class="main-menu">
        <h5 class="sidenav-heading">Main</h5>
        <ul id="side-main-menu" class="side-menu list-unstyled">
          <li><a href="#employeeDropdown" aria-expanded="false" data-toggle="collapse"> <i class="far fa-address-card"></i>ข้อมูลพนักงาน</a>
            <ul id="employeeDropdown" class="collapse list-unstyled ">
              <li><a href="/Stminishow/showEmployee">ข้อมูลพนักงาน</a></li>
              <li><a href="/Stminishow/showPosition">ข้อมูลตำแหน่ง</a></li>
            </ul>
          </li>
        </ul>
        <ul id="side-main-menu" class="side-menu list-unstyled">
          <li><a href="#prodectDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-shopping-basket"></i>ข้อมูลสินค้า</a>
            <ul id="prodectDropdown" class="collapse list-unstyled ">
              <li><a href="/Stminishow/ShowProduct">ข้อมูลสินค้า</a></li>
              <li><a href="/Stminishow/createCategory">ข้อมูลประเภทสินค้า</a></li>
              <li> <a href="/Stminishow/createBrand">ข้อมูลยี่ห้อ</a></li>
              <li> <a href="/Stminishow/createPattern">ข้อมูลลาย</a></li>
              <li> <a href="/Stminishow/createColor">ข้อมูลสี</a></li>
              <li> <a href="/Stminishow/createGen">ข้อมูลGen</a></li>
              <li> <a href="/Stminishow/createCarmodel">ข้อมูลรุ่นรถ</a></li>
            </ul>
          </li>
        </ul>
        <ul id="side-main-menu" class="side-menu list-unstyled">
          <li><a href="#partnerDropdown" aria-expanded="false" data-toggle="collapse"> <i class="far fa-handshake"></i>ข้อมูลบริษัทคู่ค้า</a>
            <ul id="partnerDropdown" class="collapse list-unstyled ">
              <li><a href="/Stminishow/showPartner">ข้อมูลบริษัทคู่ค้า</a></li>
            </ul>
          </li>
        </ul>
        <ul id="side-main-menu" class="side-menu list-unstyled">
          <li><a href="#memberDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-users"></i>ข้อมูลลูกค้า</a>
            <ul id="memberDropdown" class="collapse list-unstyled ">
              <li> <a href="/Stminishow/showMember">ข้อมูลลูกค้า</a></li>
              <li> <a href="/Stminishow/createCategorymember">ข้อมูลประเภทลูกค้า</a></li>
            </ul>
          </li>
        </ul>
        <ul id="side-main-menu" class="side-menu list-unstyled">
          <li><a href="#promotionDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-gift"></i>ข้อมูลโปรโมชั่น</a>
            <ul id="promotionDropdown" class="collapse list-unstyled ">
              <li> <a href="/Stminishow/ShowPromotionPro">โปรโมชั่นของแถม</a></li>
              <li> <a href="/Stminishow/ShowPromotionPay">โปรโมชั่นยอดชำระ</a></li>
            </ul>
          </li>
        </ul>
        <ul id="side-main-menu" class="side-menu list-unstyled">
          <li><a href="#PremiumProDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-shopping-bag"></i>ข้อมูลของแถม</a>
            <ul id="PremiumProDropdown" class="collapse list-unstyled ">
              <li><a href="/Stminishow/ShowPremiumPro">ข้อมูลของแถม</a></li>
            </ul>
          </li>
        </ul>
        <ul id="side-main-menu" class="side-menu list-unstyled">
          <li><a href="#OrderDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-truck"></i>สั่งซื้อสินค้า</a>
            <ul id="OrderDropdown" class="collapse list-unstyled ">
              <li> <a href="/Stminishow/ShowOffer">เสนอสั่งซื้อสินค้า</a></li>
              <li> <a href="/Stminishow/ShowApprove">อนุมัติสั่งซื้อสินค้า</a></li>
              <li> <a href="/Order/ShowOrder">สั่งซื้อสินค้า</a></li>
            </ul>
          </li>
        </ul>
        <ul id="side-main-menu" class="side-menu list-unstyled">
          <li><a href="#PreOrderDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-store"></i>สั่งจองสินค้า</a>
            <ul id="PreOrderDropdown" class="collapse list-unstyled ">
              <li> <a href="/Preorder/Showpreorder">สั่งจองสินค้า</a></li>
              <li> <a href="#">รับสินค้าสั่งจอง</a></li>
            </ul>
          </li>
        </ul>
        <ul id="side-main-menu" class="side-menu list-unstyled">
          <li><a href="#ReceiveDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-cart-arrow-down"></i>รับสินค้า</a>
            <ul id="ReceiveDropdown" class="collapse list-unstyled ">
              <li> <a href="/Receipt/ShowReceipt">รับสินค้า</a></li>
              <li> <a href="/Receipt/ShowLot">คลังสินค้า</a></li>
            </ul>
          </li>
        </ul>
        <ul id="side-main-menu" class="side-menu list-unstyled">
          <li><a href="#sellprodectDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-cash-register"></i>ขายสินค้า</a>
            <ul id="sellprodectDropdown" class="collapse list-unstyled ">
           

              <li> <a href="/Sell/ShowSell">ขายสินค้า</a></li>

            </ul>
          </li>
        </ul>
        <ul id="side-main-menu" class="side-menu list-unstyled">
          <li><a href="#ClaimDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-tools"></i>เคลมสินค้า</a>
            <ul id="ClaimDropdown" class="collapse list-unstyled ">
              <li> <a href="#">เคลมสินค้า</a></li>
            </ul>
          </li>
        </ul>
        <ul id="side-main-menu" class="side-menu list-unstyled">
          <li><a href="#ReportDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fas fa-chart-bar"></i>ออกรายงาน</a>
            <ul id="ReportDropdown" class="collapse list-unstyled ">
              <li><a href="#">ปริมาณยอดขายประจำปี</a></li>
              <li><a href="#">รายได้และกำไรตามช่วง</a></li>
              <li><a href="#">จำนวนสินค้าที่ขายได้</a></li>
              <li><a href="#">ยอดการใช้โปรโมชั่น</a></li>
              <li><a href="#">การเคลมสินค้าแต่ละประเภท</a></li>

            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="page">
    <!-- navbar-->
    <header class="header">
      <nav class="navbar">
        <div class="container-fluid">
          <div class="navbar-holder d-flex align-items-center justify-content-between">
            <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="index.html" class="navbar-brand">
                <div class="brand-text d-none d-md-inline-block"><strong>ST </strong><strong class="text-primary">MINI</strong></div>
              </a></div>
            <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">

              <!-- Log out-->
              <li class="nav-item"><a href="/logout" class="nav-link logout"> <span class="d-none d-sm-inline-block">ออกจากระบบ</span><i class="fa fa-sign-out"></i></a></li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <!-- Counts Section -->


    <section class="charts">
      <div class="container-fluid">
        @if(Session()->has('success'))
        <div class="alert alert-success" role="alert">
          {{Session()->get('success')}}
        </div>
        @endif
        @if(Session()->has('echo'))
        <div class="alert alert-danger" role="alert">
          {{Session()->get('echo')}}
        </div>
        @endif
        @if(Session()->has('warning'))
        <div class="alert alert-danger" role="alert">
          {{Session()->get('warning')}}
        </div>
        @endif
        {{csrf_field()}}
        @yield('body')
      </div>

    </section>


    <!-- JavaScript files-->
</body>
<script src="{{asset('/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/grasp_mobile_progress_circle-1.0.0.min.js')}}"></script>
<script src="{{asset('vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
<script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('vendor/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('js/charts-home.js')}}"></script>

<script src="{{asset('https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js')}}"></script>


<!-- Main File-->
<script src="{{asset('js/front.js')}}"></script>


</html>
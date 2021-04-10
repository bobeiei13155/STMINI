<!DOCTYPE html>
<html>
<meta charset="utf-8">
<title>STMINI</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/eef6ce42e7.js" crossorigin="anonymous"></script>
<link href="{{asset('/css/sidebar.css')}}" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>

<div class="w3-sidebar w3-bar-block w3-card w3-animate-left  bg-sidebar-green" style="display:none;" id="leftMenu">

  <button class="dropdown-btn">ข้อมูลพนักงาน
    <i class="fa fa-caret-down"></i>
  </button>
  <div class=" dropdown-container">
    <div class=" dropdown-btn">
      <a href="/Stminishow/showEmployee">ข้อมูลพนักงาน</a>
      <br>
      <a href="/Stminishow/showPosition">ข้อมูลตำแหน่ง</a>
    </div>
  </div>
  <button class="dropdown-btn">ข้อมูลสินค้า
    <i class="fa fa-caret-down"></i>
  </button>
  <div class=" dropdown-container">
    <div class=" dropdown-btn">
      <a href="/Stminishow/ShowProduct">ข้อมูลสินค้า</a>
      <br>
      <a href="/Stminishow/createCategory">ข้อมูลประเภทสินค้า</a>
      <br>
      <a href="/Stminishow/createBrand">ข้อมูลยี่ห้อ</a>
      <br>
      <a href="/Stminishow/createPattern">ข้อมูลลาย</a>
      <br>
      <a href="/Stminishow/createColor">ข้อมูลสี</a>
      <br>
      <a href="/Stminishow/createCarmodel">ข้อมูลรุ่นรถ</a>
      <br>
      <a href="/Stminishow/createGen">ข้อมูลGen</a>
    </div>
  </div>
  <button class="dropdown-btn">ข้อมูลบริษัทคู่ค้า
    <i class="fa fa-caret-down"></i>
  </button>
  <div class=" dropdown-container">
    <div class=" dropdown-btn">
      <a href="/Stminishow/showPartner">ข้อมูลบริษัทคู่ค้า</a>
    </div>
  </div>
  <button class="dropdown-btn">ข้อมูลลูกค้า
    <i class="fa fa-caret-down"></i>
  </button>
  <div class=" dropdown-container">
    <div class=" dropdown-btn">
      <a href="/Stminishow/showMember">ข้อมูลลูกค้า</a>
      <br>
      <a href="/Stminishow/createCategorymember">ข้อมูลประเภทลูกค้า</a>
    </div>
  </div>
  <button class="dropdown-btn">ข้อมูลโปรโมชั่น
    <i class="fa fa-caret-down"></i>
  </button>
  <div class=" dropdown-container">
    <div class=" dropdown-btn">
      <a href="/Stminishow/ShowPromotionPro">โปรโมชั่นของแถม</a>
      <br>
      <a href="/Stminishow/ShowPromotionPay">โปรโมชั่นยอดชำระ</a>
    </div>
  </div>
  <button class="dropdown-btn">ข้อมูลของแถม
    <i class="fa fa-caret-down"></i>
  </button>
  <div class=" dropdown-container">
    <div class=" dropdown-btn">
      <a href="/Stminishow/ShowPremiumPro">ข้อมูลของแถม</a>
    </div>
  </div>

  <button class="dropdown-btn">สั่งซื้อสินค้า
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <div class="dropdown-btn">
      <a href="#">เสนอสั่งซื้อสินค้า</a>
      <br>
      <a href="#">อนุมัติสั่งซื้อสินค้า</a>
      <br>
      <a href="#">สั่งซื้อสินค้า</a>
    </div>
  </div>
  <button class="dropdown-btn">รับสินค้า
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <div class="dropdown-btn">
      <a href="#">รับสินค้า</a>
    </div>
  </div>
  <button class="dropdown-btn">ขายสินค้า
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <div class="dropdown-btn">
      <a href="#">การขาย</a>
      <br>
      <a href="#">ประวัติการขาย</a>
    </div>
  </div>
  <button class="dropdown-btn">เคลมสินค้า
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <div class="dropdown-btn">
      <a href="#">เคลมสินค้า</a>
    </div>
  </div>
  <button class="dropdown-btn">ออกรายงาน
    <i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-container">
    <div class="dropdown-btn">
      <a href="#">ปริมาณยอดขายประจำปี</a>
      <br>
      <a href="#">รายได้และกำไรตามช่วง</a>
      <br>
      <a href="#">จำนวนสินค้าที่ขายได้</a>
      <br>
      <a href="#">ยอดการใช้โปรโมชั่น</a>
      <br>
      <a href="#">การเคลมสินค้าแต่ละประเภท</a>
    </div>
  </div>
</div>




<div class="w3-container bg-navbar-green " style="margin-top: -8px;height:70px">
  <div class="row">

    <button class=" w3-button  w3-xlarge w3-left btn-green " style="height: 70px; " onclick="openLeftMenu()">&#9776;</button>



    <div class="col " style=" padding-top: 5px;">
      <img src="https://www.img.in.th/images/05d33c376067f5b6a6332816da091819.png" width="70px" height="70px"></img>
    </div>
    <div class="col">
      <div class="float-right">

        <label class="dorplabel" style="color: #000;
    padding: 30px;
    font-size: 16px;
    border: none;
    font-family:Roboto;font-size: 18px; 
    font-weight: bold;">{{session()->get('fname')}}</label>
        <a class="dorpa" href="/logout" style="color: #000;
    padding: 10px;
    font-size: 18px;
    border: none;
    text-decoration: none;
    font-family:Roboto;font-size: 18px; 
    font-weight: bold;"> ออกจากระบบ</a>


      </div>
    </div>
  </div>


</div>
</div>





<div class="w3-container " style="margin-top:60px;">

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

<script>
  function openLeftMenu() {
    var x = document.getElementById("leftMenu");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }
  // function openLeftMenu() {
  //   document.getElementById("leftMenu").style.display = "block";
  // }

  // function closeLeftMenu() {
  //   document.getElementById("leftMenu").style.display = "none";
  // }

  var dropdown = document.getElementsByClassName("dropdown-btn");
  var i;

  for (i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var dropdownContent = this.nextElementSibling;
      if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
      } else {
        dropdownContent.style.display = "block";
      }
    });
  }


  function clickIE() {
    if (document.all) {
      alert(message);
      return false;
    }
  }

  function clickNS(e) {
    if (document.layers || (document.getElementById && !document.all)) {
      if (e.which == 2 || e.which == 3) {
        alert(message);
        return false;
      }
    }
  }
  if (document.layers) {
    document.captureEvents(Event.MOUSEDOWN);
    document.onmousedown = clickNS;
  } else {
    document.onmouseup = clickNS;
    document.oncontextmenu = clickIE;
  }
  document.oncontextmenu = new Function("return false")
</script>



</html>



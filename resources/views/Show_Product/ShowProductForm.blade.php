<!DOCTYPE html>
<html>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
<style>
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: "Karma", sans-serif
    }

    .w3-bar-block .w3-bar-item {
        padding: 20px
    }
</style>

<body>

    <!-- Sidebar (hidden by default) -->
    <nav class="w3-sidebar w3-bar-block w3-card w3-top w3-xlarge w3-animate-left" style="display:none;z-index:2;width:40%;min-width:300px" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button">Close Menu</a>
        <a href="#food" onclick="w3_close()" class="w3-bar-item w3-button">Food</a>
        <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button">About</a>
    </nav>

    <!-- Top menu -->
    <div class="w3-top">
        <div class="w3-white w3-xlarge" style="max-width:1200px;margin:auto">
            <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()">☰</div>
            <div class="w3-center w3-padding-16">
                <div class="brand-text d-none d-md-inline-block"><strong>ST </strong><strong style="color:#42E267;">MINI</strong></div>
            </div>
        </div>
    </div>

    <div class="mainmenu-area">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                       <!--  <li><a href="index.php">หน้าหลัก</a></li> -->
                        <li class="active"><a href="product-all.php">สินค้าทั้งหมด</a></li>
                        <li><a href="product-food.php">อาหารสัตว์</a></li>
                        <li><a href="product-access.php">อุปกรณ์สัตว์</a></li>
                        <!-- <li><a href="shop.html">โปรโมชั่น</a></li>
                        <li><a href="#">ติดต่อ</a></li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div> <!-- End mainmenu area -->
    <!-- !PAGE CONTENT! -->
    <div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">

        <!-- First Photo Grid-->
        <div class="w3-row-padding w3-padding-16 w3-center" id="food">
            @foreach($products as $product)
            <div class="w3-quarter">
                <img src="{{asset('storage')}}/Products_image/{{$product->Img_Product}}" alt="Sandwich" style="width:200px;height:200px">
                <h3>{{$product->Name_Product}}</h3>
                <p>{{number_format($product->Price)}}</p>
            </div>
            @endforeach
        </div>




        <!-- Pagination -->


        <hr id="about">


        <!-- End page content -->
    </div>

    <script>
        // Script to open and close sidebar
        function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
        }

        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
        }
    </script>

</body>

</html>
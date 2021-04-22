<html>
<header>
    <title>pdf</title>
    <meta http-equiv="Content-Language" content="th" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'sarabun_new', sans-serif;
            font-size: 20px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .w80 {
            width: 30%;
            font-size: 20px;
        }

        .w10 {
            width: 20%;
            font-size: 20px;
        }

        .w20 {
            width: 10%;
            font-size: 20px;
        }
    </style>
</header>

<body>
    <div class="center">
        <h2>
            <img src="https://sv1.picz.in.th/images/2021/04/21/AqLpIS.png" width="60px" height="40px">
        </h2>
        ST MINI (เอสที มินิ)
        <br>
        ใบเสร็จรับเงิน
    </div>
    <hr>
    @foreach($sells as $sell)
    <table>
        <tr>
            <td width="250px">
                <span>รหัสใบเสร็จ : {{$sell->Id_Sell}}</span>
            </td>
            <td>
                <span>พนักงาน : {{$sell->FName_Emp}}</span>
            </td>
        </tr>
    </table>
    <table>

        <tr>
            <td width="250px">
                <span>เวลา : {{substr($sell->Sell_Date, 10)}} น.</span>
            </td>
            <td>
                <span>วันที่ : {{substr($sell->Sell_Date,0, 10)}}</span>
            </td>
        </tr>
        
    </table>


    <hr>
    <table>
        <tr>
            <td width="100px">ชื่อสินค้า</td>
            <td width="70px">วันหมดประกัน</td>
            <td width="70px">จำนวน</td>
            <td width="70px">ราคารวม</td>
        </tr>
        @foreach ($product_sells as $product_sell)
        <tr>
            <td width="100px"> {{$product_sell->Name_Product}} </td>
            <td width="120px"> {{$product_sell->End_Insurance}} </td>
            <td width="70px"> {{$product_sell->Amount_Sell}} </td>
            <td width="60px"> {{number_format($product_sell->Total_Price, 2)}} </td>
        </tr>

        @endforeach
    </table>
    <hr>
    <table style="font-size: 16px;">
        @foreach ($premium_payments as $premium_payment)
        <tr>
            <td  width="250px">** {{$premium_payment->Name_Premium_Pro}} </td>
            <td > {{$premium_payment->Amount_Premium_Pro}} </td>
         
        </tr>
        @endforeach
    </table>
    <table style="font-size: 16px;" >
        @foreach ($premium_products as $premium_product)
        <tr>
            <td  width="250px">** {{$premium_product->Name_Premium_Pro}} </td>
            <td > {{$premium_product->Amount_Premium_Pro}} </td>
         
        </tr>
        @endforeach
    </table>
    <hr>
    <table>
        <tr>
            <td width="200px">
                <span>ชื่อสมาชิก : {{$sell->Name_Member}}</span>
            </td>
            <td>
                <span>ยอดชำระ : {{number_format($sell->Payment)}} บาท</span>
            </td>

        </tr>

    </table>

    @endforeach
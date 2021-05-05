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

        /* table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        } */
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

    <table>
        @foreach($orders as $order)
        <tr>
            <td width="400px">
                <span>ชื่อบริษัท :
                    @foreach($partners as $partner)
                    {{$partner->Name_Partner}}
                    @endforeach
                </span>
            </td>
            <td>
                <span>รหัสใบสั่งซื้อ : {{$order->Id_Order}} </span>
            </td>
        </tr>
    </table>
    <table>

        <tr>
            <td width="400px">
                @foreach($address as $row)
                <span>ที่อยู่ : {{$row->Address_Partner}}

                </span>

                @endforeach
            </td>
            <td>
                <span>วันที่่สั่งซื้อ : {{$order->Order_Date}}</span>
            </td>
        </tr>
        <tr>

            <td width="400px">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$row->AMPHUR_NAME}} {{$row->DISTRICT_NAME}}{{$row->PROVINCE_NAME}}
            </td>
            <td>
                <span>ชื่อพนักงาน :

                    {{$order->FName_Emp}}

                </span>
            </td>
        </tr>
        @endforeach
    </table>
    <hr>
    <table>

        <tr>
            <th width="70">ลำดับ</th>
            <th width="300">รายการ</th>
            <th width="80">จำนวน</th>
            <th width="100">ราคา/หน่วย</th>
            <th width="100">ราคารวม</th>
        </tr>

        @foreach($products as $product)
        <tr>
            <th width="70" style="font-weight:normal;">{{$product->No_Order}}</th>
            <th width="300" style="font-weight:normal;">{{$product->Name_Product}}</th>
            <th width="80" style="font-weight:normal;">{{$product->Amount_Order}}</th>
            <th width="100" style="font-weight:normal;">{{number_format($product->Cost)}}</th>
            <th width="100" style="font-weight:normal;">{{number_format($product->Total)}}</th>
        </tr>
        @endforeach



    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <hr>
    <table>
        @foreach($orders as $order)
        <tr>
            <td width="400px">

            </td>
            <td>
                <span>ราคาสุทธิสินค้าที่เสียภาษี : 
                {{number_format($order->Total_Price-(($order->Total_Price)* 0.07))}} บาท
                </span>
            </td>
        </tr>
        <tr>

            <td width="400px">

            </td>
            <td>
                <span>ภาษีมูลค่าเพิ่ม 7 % :
                &nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;
                {{number_format(($order->Total_Price)* 0.07)}} บาท

                </span>
            </td>
        </tr>
        <tr>

            <td width="400px">

            </td>
            <td>
                <span>ยอดรวมสุทธิ :
                &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;
                    {{number_format($order->Total_Price)}} บาท

                </span>
            </td>
        </tr>
        @endforeach
    </table>
</body>

</html>
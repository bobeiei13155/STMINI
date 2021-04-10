@extends('layouts.stmininav')
@section('body')

<div class="container my-2">
    <h2 class="font_green">เลือกสินค้าของแถม</h2>
    <form action="#" method="GET" enctype="multipart/form-data">
    
        <div class="row">
            <div class="col-sm-2">
                <input type="text" name="searchPMP" class="form-control" style="width: 200px;">
            </div>
            <div class="col-sm-2">
                <button type="submit" name="submit" class="btn btn-green "><i class="fas fa-search"></i></button>
                <a class="btn btn-danger " href="/Stminishow/createPromotionPay">กลับ</a>
            </div>
        </div>

        <!-- <a class="btn btn-green my-2 " href="/Stminishow/createPremiumPro">เพิ่มของแถม</a> -->
        <table class="table">
            <thead class="thead-green">
                <tr class="line">
                    <th scope="col">รหัสของแถม</th>
                    <th scope="col">ชื่อของแถม</th>
                    <th scope="col">รูป</th>
                    <th scope="col">จำนวน</th>
                    <th scope="col">เลือกสินค้า</th>
                </tr>
            </thead>

            <tbody class="font_green ">
                @foreach($premium_pros as $PremiumPro)
                <tr>

                    <td scope="row" style="vertical-align:middle">{{$PremiumPro->Id_Premium_Pro}}</td>
                    <td style="vertical-align:middle">{{$PremiumPro->Name_Premium_Pro}}</td>
                    <td style="vertical-align:middle">
                        <img src="{{asset('storage')}}/PremiumPro_image/{{$PremiumPro->Img_Premium_Pro}}" alt="" width="150px" height="150px">
                    </td>
                    <td style="vertical-align:middle">{{$PremiumPro->Amount_Premium_Pro}}</td>
                    <td style="vertical-align:middle">
                        <a href="/Stminishow/addToCartPay/{{$PremiumPro->Id_Premium_Pro}}" class="btn btn-green">เลือกสินค้า</a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </form>
</div>
@endsection
@extends('layouts.stmininav')
@section('body')
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
<div class="container ">
    <br>

    <h2 class="font_green">แก้ไขโปรโมชั่นยอดชำระ</h2>
    <form action="/Stminishow/createPromotionPay" method="post" enctype="multipart/form-data">
        {{csrf_field()}}


        <div class="form-group">
            <div class="row">

                <div class="col-md-3">
                    <label for="Name_Promotion" class="font_green">ชื่อโปรโมชั่น</label>
                    <input type="text" class="form-control" name="Name_Promotion" id="Name_Promotion" placeholder="ชื่อโปรโมชั่น" value="{{$payment_amounts->Name_Promotion}}">
                </div>
                <div class="col-md-3">
                    <label for="Payment_Amount" class="font_green">กำหนดยอดชำระ/บาท</label>
                    <input type="number" class="form-control" name="Payment_Amount" id="Payment_Amount" placeholder="กำหนดยอดชำระ" onkeypress="return onlyNumberKey(event)" min="0" value="{{$payment_amounts->Payment_Amount}}">
                </div>
                <div class="col-md-3">
                    <label for="Sdate_Promotion" class="font_green">วันเริ่มต้น</label>
                    <input type="date" class="form-control" name="Sdate_Promotion" id="Sdate_Promotion" value="{{$payment_amounts->Sdate_Promotion}}">
                </div>
                <div class="col-md-3">
                    <label for="Edate_Promotion" class="font_green">วันสิ้นสุด</label>
                    <input type="date" class="form-control" name="Edate_Promotion" id="Edate_Promotion" value="{{$payment_amounts->Edate_Promotion}}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <a class="btn btn-green my-2 " href="/Stminishow/indexPremiumPro">เลือกสินค้าของแถม</a>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="submit" class="btn btn-success">แก้ไข</button>

                    <a class="btn btn-danger my-2" href="/Stminishow/ShowPromotionPay">กลับ</a>
                </div>
            </div>
        </div>
        <table class="table">
            <thead class="thead-green">
                <tr class="line">
                    <th scope="col">รหัสของแถม</th>
                    <th scope="col">ชื่อของแถม</th>
                    <th scope="col">รูป</th>
                    <th scope="col">จำนวน</th>

                    <th scope="col">ลบ</th>
                </tr>
            </thead>

            <tr>
                @if(empty($CartItems->items))
                <tbody class="font_green ">
                    <tr>
                        <td colspan="6"> ไม่มีสินค้าของแถม </td>
                    </tr>

                </tbody>

                @else

                <tbody class="font_green ">

                    @foreach($CartItems->items as $item)
                    <tr>

                        <td scope="row" style="vertical-align:middle">{{$item['data']['Id_Premium_Pro']}}</td>

                        <td style="vertical-align:middle">{{$item['data']['Name_Premium_Pro']}}</td>

                        <td style="vertical-align:middle">
                            <img src="{{asset('storage')}}/PremiumPro_image/{{$item['data']['Img_Premium_Pro']}}" alt="" width="150px" height="150px">
                        </td>
                        <td class="" style="vertical-align:middle">
                            <div class="">
                                <a class="" href="/Stminishow/incrementCart/{{$item['data']['Id_Premium_Pro']}}"> + </a>
                                <input class="numbertext" type="text" name="quantity[]" value="{{$item['quantity']}}" autocomplete="off" size="2">
                                <a class="" href="/Stminishow/decrementCart/{{$item['data']['Id_Premium_Pro']}}"> - </a>
                            </div>
                        </td>

                        <td style="vertical-align:middle"><a href="/Stminishow/deleteFromCart/{{$item['data']['Id_Premium_Pro']}}" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" class="btn btn-danger">ลบ</a></td>

                    </tr>
                    @endforeach

                </tbody>
                @endif
        </table>

        @if($CartItems == null){
        <div class="container">
            <div class="row">
                <div class="col-sm-12 font_green">
                    <div class="total_area">
                        <ul>
                            <li>จำนวนสินค้า<span>0</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        }@else{
        <div class="container">
            <div class="row">
                <div class="col-sm-12 font_green">
                    <div class="total_area">
                        <ul>
                            <li>จำนวนสินค้า<span>{{$CartItems->totalQuantity}}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        }
        @endif


    </form>

</div>

{{csrf_field()}}
<script>
    function onlyNumberKey(evt) {


        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
</script>

@endsection
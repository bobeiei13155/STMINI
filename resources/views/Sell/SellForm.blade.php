@extends('layouts.stmininav')
@section('body')
<div class="container-fluid">
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
<section class="forms">
    <form action="# " method="post" enctype="multipart/form-data">
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h1 display">ขายสินค้า</h1>
            </header>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header  align-items-center">

                            <div class="form-group row">
                                <div class="input-group col-sm-2">
                                    <div class="i-checks">
                                        <input id="radioCustom1" onclick="chk_value()" type="radio" value="option1" name="a" class="form-control-custom radio-custom" checked>
                                        <label for="radioCustom1">ลูกค้าทั่วไป</label>
                                    </div>
                                </div>

                                <div class="input-group col-sm-2">

                                </div>
                                <div class="input-group col-sm-1">

                                </div>
                                <div class="input-group col-sm-1">

                                </div>
                                <div class="input-group col-sm-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default">เวลา :</span>
                                    </div>
                                    <input type="text" class="form-control" name="Receipt_date" id="Receipt_date" value="<?php echo date(' H:i:s'); ?>" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px;" readonly>
                                </div>
                                <div class="input-group col-sm-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default">วันที่ :</span>
                                    </div>
                                    <input type="text" class="form-control" name="Receipt_date" id="Receipt_date" value="<?php echo date('Y-m-d'); ?>" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px;" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-sm-2">
                                    <div class="i-checks">
                                        <input id="radioCustom2" type="radio" value="option2" name="a" onclick="chk_value()" class="form-control-custom radio-custom">
                                        <label for="radioCustom2">ลูกค้าสมาชิก</label>
                                    </div>
                                </div>

                                <div class="input-group col-sm-3">
                                    <input type="text" class="form-control a1 text-center" id="member" name="member" value="" placeholder="--->ชื่อลูกค้าสมาชิก<---" style="color:#495057 ;background-color: #E8ECEE; border-radius: 10px 0px 0px 10px;" disabled>
                                    <input type="hidden" class="form-control " id="id_member" name="id_member" value="">
                                    <div class="input-group-prepend">
                                        <button type="button" data-toggle="modal" data-target="#myModal" class="input-group-text " id="s_member" id="inputGroup-sizing-default" style="background-color: #c1c1c1;color:black; border-radius: 0px 10px 10px 0px;" disabled><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="input-group col-sm-4">

                                </div>

                                <div class="input-group col-sm-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default">พนักงานขาย :</span>
                                    </div>
                                    <input type="text" class="form-control" value="{{session()->get('fname')}}" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px;" disabled>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- Modal-->
        <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog modal-lg">
                <div class="modal-content" style="width: auto;">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">ลูกค้าสมาชิก</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <table class="table text-center" id="table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>รหัสสมาชิก</th>
                                    <th>ชื่อ</th>
                                    <th>นามสกุล</th>
                                    <th>เบอร์โทร</th>
                                    <th>ประเภทลูกค้า</th>
                                    <th>ส่วนลดลูกค้า</th>
                                    <th>เลือก</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $member)
                                <tr>
                                    <td> {{$member->Id_Member}}</td>
                                    <td> {{$member->FName_Member}}</td>
                                    <td> {{$member->LName_Member}}</td>
                                    @foreach($telmems as $telmem)
                                    @if($telmem->Id_Member == $member->Id_Member)
                                    <td> {{$telmem->Tel_MEM}}</td>
                                    @break
                                    @endif
                                    @endforeach
                                    <td> {{$member->Name_Cmember}}</td>
                                    <td> {{$member->Discount_Cmember}}</td>
                                    <td> <button type="button" class="btn btn-info buttonID" id="{{$member->Id_Member}}" data-dismiss="modal" aria-label="Close" class="close" style="border-radius: 5px; "> <i class="fas fa-hand-pointer" style="margin-right: 5px;"></i> เลือก</button></td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal_Promotion_Product-->
        <div id="myModal_Promotion_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog modal-lg">
                <div class="modal-content" style="width: auto;">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title"><i class="fas fa-star" style="color:#F0B71A ;padding-right: 8px;"></i> โปรโมชั่นของแถม</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <table class="table text-center" id="table_promotion_product" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>ชือโปรโมชั่น</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>วันเริ่มต้น</th>
                                    <th>วันสิ้นสุด</th>
                                    <th>รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promotions as $promotion)
                                <tr>
                                    <td>{{$promotion->Name_Promotion}}</td>
                                    <td>{{$promotion->Name_Product}}</td>
                                    <td>{{$promotion->Sdate_Promotion}}</td>
                                    <td>{{$promotion->Edate_Promotion}}</td>
                                    <td> <button type="button" class="btn btn-warning ID_Promotion_Product " id="{{$promotion->Id_Promotion}} " style="border-radius: 5px;  " data-toggle="modal" data-target="#myModal_Promotion_De_1_1"> <i class="fas fa-eye"></i></button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>


        <div id="myModal_Promotion_De_1_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog modal-lg">
                <div class="modal-content" style="width: auto;">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title"><i class="fas fa-star" style="color:#F0B71A; padding-right: 8px; "></i>รายละเอียดโปรโมชั่นยอดชำระ</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="show_product_promotion">

                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- Modal_Promotion_Payment-->
        <div id="myModal_Promotion_Payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog modal-lg">
                <div class="modal-content" style="width: auto;">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title"><i class="fas fa-fire-alt" style="color:#6586FA; padding-right: 8px; "></i>โปรโมชั่นยอดชำระ</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <table class="table text-center" id="table_promotion_payment" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>ชือโปรโมชั่น</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>วันเริ่มต้น</th>
                                    <th>วันสิ้นสุด</th>
                                    <th>รายละเอียด</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promotionpays as $promotionpay)
                                <tr>
                                    <td>{{$promotionpay->Name_Promotion}}</td>
                                    <td>{{$promotionpay->Name_Brand}}</td>
                                    <td>{{$promotionpay->Sdate_Promotion}}</td>
                                    <td>{{$promotionpay->Edate_Promotion}}</td>
                                    <td> <button type="button" class="btn btn-warning ID_Promotion_Payment " id="{{$promotionpay->Id_Promotion}} " style="border-radius: 5px;  " data-toggle="modal" data-target="#myModal_Promotion_De_2"> <i class="fas fa-eye"></i></button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div id="myModal_Promotion_De_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog modal-lg">
                <div class="modal-content" style="width: auto;">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title"><i class="fas fa-star" style="color:#6586FA; padding-right: 8px; "></i>รายละเอียดโปรโมชั่นยอดชำระ</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="show_payment_promotion">

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid ">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body ">

                            <div class="form-group row">
                                <div class="  " style="padding-top: 10px; padding-right: 10px ;padding-left: 15px ; ">

                                    <h2>เลือกสินค้า :<h2>

                                </div>
                                <div class="input-group col-sm-3 ">
                                    <div class="input-group-prepend">
                                        <button type="button" data-toggle="modal" data-target="#myModal_Product" class="input-group-text " id="s_member" id="inputGroup-sizing-default" style="background-color: #42A667;color:#FFF; border-radius: 10px 0px 0px 10px; height:40px;"><i class="fas fa-search"></i></button>
                                    </div>
                                    <input type="text" class="form-control" id="tags" value="" style="background-color: #FFF; border-radius: 0px 10px 10px 0px;">
                                </div>
                                <div class=" col">
                                </div>
                                <div class=" col-sm-3">
                                    <button type="button" data-toggle="modal" data-target="#myModal_Promotion_Product" class="btn btn-warning" style=" border-radius: 5px; height:40px; "><i class="fas fa-star" style="color:#FFF ; ">โปรโมชั่นของแถม</i></button>
                                </div>
                                <div class=" col-sm-3 ">
                                    <button type="button" data-toggle="modal" data-target="#myModal_Promotion_Payment" class="btn btn-info " style=" border-radius: 5px; height:40px;"><i class="fas fa-fire-alt " style="color:#FFF"> โปรโมชั่นยอดชำระ</i></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid ">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body ">
                            {{csrf_field()}}
                            <h2>รายการสินค้า</h2>
                            <table class="table  table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col" width="6%">รูปภาพ</th>
                                        <th scope="col" width="9%">ชื่อสินค้า</th>
                                        <th scope="col" width="5%">ยี่ห้อ</th>
                                        <th scope="col" width="5%">ราคา</th>
                                        <th scope="col" width="5%">จำนวน</th>
                                        <th scope="col" width="5%">ราคารวม</th>
                                        <th scope="col" width="5%">ลบ</th>
                                    </tr>

                                </thead>

                            </table>

                            <div class="show_product">
                            </div>
                            <br>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body ">

                            {{csrf_field()}}
                            <h2>รายการของแถม</h2>
                            <table class="table  table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col" width="6%">รูปภาพ</th>
                                        <th scope="col" width="9%">ชื่อของแถม</th>
                                        <th scope="col" width="5%">จำนวน</th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="show_premium_product">
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid ">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body ">
                            <div class="form-group row">
                                <div class="input-group col-sm-5 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default">การชำระเงิน</span>
                                    </div>
                                    <select class="form-control " name="Payment" style="border-radius: 0px 10px 10px 0px;">
                                        <option value="">--> เลือกการชำระ <-- </option>
                                        <option value="เงินสด">เงินสด</option>
                                        <option value="โอนเงิน">โอนเงิน</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 ">

                                </div>
                                <div class="input-group col-sm-4 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:130px">รับเงิน :</span>
                                    </div>
                                    <input type="text" class="form-control text-center" name="Receipt_date" id="Receipt_date" value="">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="background-color: #c1c1c1;color:black; border-radius: 0px 10px 10px 0px;"> บาท</span>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="input-group col-sm-5 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:130px">ราคารวม :</span>
                                    </div>
                                    <input type="text" class="form-control text-center" name="Receipt_date" id="Receipt_date" value="0.00" style="background-color: #E8ECEE;  " readonly>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="background-color: #c1c1c1;color:black; border-radius: 0px 10px 10px 0px;"> บาท</span>
                                    </div>
                                </div>



                            </div>
                            <div class="form-group row">
                                <div class="input-group col-sm-5 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:130px">ส่วนลดสมาชิก :</span>
                                    </div>
                                    <input type="text" class="form-control text-center" name="Receipt_date" id="Receipt_date" value="-" style="background-color: #E8ECEE;  " readonly>
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="background-color: #c1c1c1;color:black; border-radius: 0px 10px 10px 0px; width:55px;"> %</span>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="input-group col-sm-5 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:130px">ยอดชำระ :</span>
                                    </div>
                                    <input type="text" class="form-control text-center total" name="total" id="total" value="0.00" style="background-color: #E8ECEE; height:40px " readonly>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="background-color: #c1c1c1;color:black; border-radius: 0px 10px 10px 0px;"> บาท</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 ">

                                </div>
                                <div class="col-sm-4">

                                    <button type="submit" name="submit" class="btn btn-primary " style="width:100%; height:40px; background-color: #42A667; border-color: #42A667; border-radius: 10px;"><i class="fas fa-cash-register fa-2x"></i> </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Modal_Product-->
        <div id="myModal_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog modal-xl">
                <div class="modal-content" style="width: auto;">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">สินค้า</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <table class="table text-center" id="table_product" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>รหัส</th>
                                    <th>ชื่อ</th>
                                    <th>ประเภท</th>
                                    <th>ยี่ห้อสินค้า</th>
                                    <th>GEN</th>
                                    <th>ราคา</th>
                                    <th>จำนวนสินค้าที่ขายได้</th>
                                    <th>โปรโมชั่นของแถม</th>
                                    <th>เลือก</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td> {{$product->Id_Product}}</td>
                                    <td> {{$product->Name_Product}}</td>
                                    <td>
                                        @foreach($categories as $category)
                                        @if($product->Category_Id == $category->Id_Category)
                                        {{$category->Name_Category}}
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($brands as $brand)
                                        @if($product->Brand_Id == $brand->Id_Brand)
                                        {{$brand->Name_Brand}}
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($gens as $gen)
                                        @if($product->Gen_Id == $gen->Id_Gen)
                                        {{$gen->Name_Gen}}
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        {{number_format($product->Price,2)}}
                                    </td>
                                    <td>

                                        @foreach($lot_products as $lot_product)
                                        @if($product->Id_Product == $lot_product->Id_Product)
                                        @if(($lot_product->Amount_Lot - $lot_product->Amount_Preorder) <= 0) <div style="color:red"> 0<input type="hidden" class="form-control text-center noHover" value=" 0" name="Amount_Sell[]">
                    </div>
                    @else
                    {{$lot_product->Amount_Lot - $lot_product->Amount_Preorder}}
                    <input type="hidden" class="form-control text-center noHover" value=" {{$lot_product->Amount_Lot - $lot_product->Amount_Preorder}}" name="Amount_Sell[]">
                    @endif


                    @endif

                    @endforeach



                    </td>
                    <td>
                        @foreach($promotions as $promotion)
                        @if($product->Id_Product == $promotion->Id_Product)
                        <button type="button" class="btn btn-warning ID_Promotion_Product " id="{{$promotion->Id_Promotion}} " style="border-radius: 5px;  " data-toggle="modal" data-target="#myModal_Promotion_De_1"> <i class="fas fa-eye"></i></button>
                        <input type="hidden" value="{{$promotion->Id_Promotion}} " name="Id_Promotion_Product_inp[]">
                        @endif
                        @endforeach
                    </td>



                    <td> <button type="button" class="btn btn-primary buttonID_Product" id="{{$product->Id_Product}}" style="border-radius: 5px; width: 120px; " data-toggle="modal" data-target="#myModalOffer"> <i class="fas fa-cart-arrow-down" style="margin-right: 5px;"></i> เลือกสินค้า</button></td>
                    </tr>
                    @endforeach

                    </tbody>
                    </table>

                </div>
            </div>
        </div>


        <div id="myModal_Promotion_De_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog modal-lg">
                <div class="modal-content" style="width: auto;">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title"><i class="fas fa-star" style="color:#F0B71A; padding-right: 8px; "></i>รายละเอียดโปรโมชั่นยอดชำระ</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="show_product_promotion">

                        </div>

                    </div>
                </div>
            </div>
        </div>



    </form>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable({
            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "All"]
            ]
        });
        $('#table_product').DataTable({
            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "All"]
            ]
        });
        $('#table_promotion_product').DataTable({
            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "All"]
            ]
        });

        $('#table_promotion_payment').DataTable({
            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "All"]
            ]
        });
    });






    function chk_value() {

        var enabled = document.getElementById('radioCustom2').checked;

        document.getElementById('member').readonly = !enabled;
        document.getElementById('s_member').disabled = !enabled;


    }



    $(document).on("click", ".buttonID", function() {

        var Id_Member = $(this).attr("Id");
        var _token = $('input[name="_token"]').val();
        // swal(Id_Member);
        // var job = $('#' + penis_test + ' td:nth-child(2)').html();
        $.ajax({
            url: "{{route('sell.select_member')}}",
            method: "POST",
            data: {
                Id_Member: Id_Member,
                _token: _token
            },
            success: function(result) {

                $('input[name="member"]').val(result);
            }
        })



    });


    $(document).on("click", ".buttonID", function() {

        var Id_Member = $(this).attr("Id");

        var _token = $('input[name="_token"]').val();
        // swal(Id_Member);
        // var job = $('#' + penis_test + ' td:nth-child(2)').html();
        $.ajax({
            url: "{{route('sell.select_id_member')}}",
            method: "POST",
            data: {
                Id_Member: Id_Member,
                _token: _token
            },
            success: function(result) {

                $('input[name="id_member"]').val(result);
            }
        })



    });

    $(document).on("click", ".buttonID_Product", function() {

        var value = $(this).parent().parent();
        var Id_Product = $(this).attr("Id");

        var _token = $('input[name="_token"]').val();
        var test = $(this).closest('tr')
        let Id_Promotion_Product = test.find("input[name='Id_Promotion_Product_inp[]']").val();


        var Amount_Sell = value.find("input[name='Amount_Sell[]']").val();

        if (Amount_Sell == 0) {
            swal('สินค้าหมด');
            exit();
        }

        if (typeof Id_Promotion_Product === "undefined") {
            $.ajax({
                url: "{{route('sell.select_Id_Product')}}",
                method: "POST",
                data: {
                    Id_Product: Id_Product,
                    Amount_Sell: Amount_Sell,
                    _token: _token
                },
                success: function(result) {
                    $('.show_product').append(result);
                }
            });
        } else {
            // swal(Id_Promoiton_Product);
            $.ajax({
                url: "{{route('sell.select_Id_Product')}}",
                method: "POST",
                data: {
                    Id_Product: Id_Product,
                    Amount_Sell: Amount_Sell,
                    _token: _token
                },
                success: function(result) {
                    $('.show_product').append(result);
                }
            });

            $.ajax({
                url: "{{route('sell.select_Promotion_Product')}}",
                method: "POST",
                data: {
                    Id_Promotion_Product: Id_Promotion_Product,
                    _token: _token
                },
                success: function(result) {
                    $('.show_premium_product').append(result);
                }
            });

        }
        // var job = $('#' + penis_test + ' td:nth-child(2)').html();




    });

    $(document).on("change", ".the_input_approve", function() {

        let test = $(this).closest('tr')
        let input_approve = test.find('.the_input_approve').val();
        let input_cost = test.find('.the_input_cost').val();
        // var  b = parseInt(input_cost);

        // var input_approvemyJSON = JSON.stringify(input_approve);
        // var input_costmyJSON = JSON.stringify(input_cost);

        // test.find('.total_cost').val(input_cost * input_approve);
        // new Intl.NumberFormat().format()
        // .toLocaleString()


        test.find('.total_cost_s').val((input_approve * input_cost).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
        test.find('.total_cost').val((input_approve * input_cost));

        var cnt = 0;

        $('.total_cost').each(function() {

            var total = parseFloat($(this).val());

            cnt += total;
        });



        $('#total').val(cnt.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));

    });


    $(document).on("click", ".ID_Promotion_Product", function() {

        var Id_Promotion = $(this).attr("Id");
        // swal(button_test);
        var _token = $('input[name="_token"]').val();
        // var job = $('#' + penis_test + ' td:nth-child(2)').html();

        $.ajax({
            url: "{{route('sell.Detail_Promotion_Products')}}",
            method: "POST",
            data: {
                Id_Promotion: Id_Promotion,
                _token: _token
            },
            success: function(show_product_promotion) {
                // $('.showcost').append(showcost);
                $('.show_product_promotion').html(show_product_promotion);
            }
        })


    });


    $(document).on("click", ".ID_Promotion_Payment", function() {

        var Id_Promotion = $(this).attr("Id");
        // swal(Id_Promotion);
        var _token = $('input[name="_token"]').val();
        // var job = $('#' + penis_test + ' td:nth-child(2)').html();

        $.ajax({
            url: "{{route('sell.Detail_Promotion_Payments')}}",
            method: "POST",
            data: {
                Id_Promotion: Id_Promotion,
                _token: _token
            },
            success: function(show_payment_promotion) {
                // $('.showcost').append(showcost);
                $('.show_payment_promotion').html(show_payment_promotion);
            }
        })


    });



    $(document).on("click", ".Button_Select_Promotion_Product", function() {


        var Id_Promotion_Product = $(this).attr("Id");

        var _token = $('input[name="_token"]').val();

        // alert(Id_Promotion_Product);
        $.ajax({
            url: "{{route('sell.select_Promotion_Product')}}",
            method: "POST",
            data: {
                Id_Promotion_Product: Id_Promotion_Product,
                _token: _token
            },
            success: function(result) {
                $('.show_product').append(result);
            }
        });



    });
</script>


@endsection
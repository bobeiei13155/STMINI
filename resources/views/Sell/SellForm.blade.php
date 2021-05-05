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
    <form action="/Sell/storeSell" method="post" enctype="multipart/form-data">
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h1 display">ขายสินค้า</h1>
            </header>
            <textarea id="chk_Payment" name="chk_Payment" rows="10" hidden>

            </textarea>
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
                                    <input type="text" class="form-control" name="Time" id="Time" value="<?php echo date(' H:i:s'); ?>" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px;" readonly>
                                </div>
                                <div class="input-group col-sm-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default">วันที่ :</span>
                                    </div>
                                    <input type="text" class="form-control" name="date_sell" id="date_sell" value="<?php echo date('Y-m-d'); ?>" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px;" readonly>
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
                        <h5 id="exampleModalLabel" class="modal-title"><i class="fas fa-star" style="color:#6586FA; padding-right: 8px; "></i>รายละเอียดโปรโมชั่นยอดชำระ</h5>
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
                                    <th>ชื่อยี่ห้อ</th>
                                    <th>วันเริ่มต้น</th>
                                    <th>วันสิ้นสุด</th>
                                    <th>รายละเอียด</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promotionpays as $promotionpay)
                                <tr>
                                    <td>{{$promotionpay->Name_Promotion}}</td>
                                    <td>{{$promotionpay->Name_Brand}}
                                        <input type="hidden" class="form-control text-center noHover Id_Brand_Promotion_Get" value="{{$promotionpay->Id_Brand}} " name="Id_Brand_Promotion[]">
                                        <input type="hidden" class="Payment_Amount" value="{{$promotionpay->Payment_Amount}} " name="Payment_Amount[]">
                                    </td>
                                    <td>{{$promotionpay->Sdate_Promotion}}</td>
                                    <td>{{$promotionpay->Edate_Promotion}}</td>
                                    <td> <button type="button" class="btn btn-warning ID_Promotion_Payment " id="{{$promotionpay->Id_Promotion}} " value="{{$promotionpay->Id_Promotion}} " style="border-radius: 5px;  " data-toggle="modal" data-target="#myModal_Promotion_De_2"> <i class="fas fa-eye"></i></button></td>
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
                        <h5 id="exampleModalLabel" class="modal-title"><i class="fas fa-fire-alt" style="color:#6586FA; padding-right: 8px; "></i>รายละเอียดโปรโมชั่นยอดชำระ</h5>
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
                                        <button type="button" data-toggle="modal" data-target="#myModal_Product" class="input-group-text " id="s_product" id="inputGroup-sizing-default" style="background-color: #42A667;color:#FFF; border-radius: 10px 0px 0px 10px; height:40px;"><i class="fas fa-search"></i></button>
                                    </div>
                                    <input type="text" class="form-control" id="tags" value="" style="background-color: #FFF; border-radius: 0px 10px 10px 0px;" readonly>
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
                                        <th scope="col" width="5%">วันที่หมดประกัน</th>
                                        <th scope="col" width="5%">ลบ</th>
                                    </tr>

                                </thead>
                                <tbody id="body_product">
                                </tbody>
                            </table>


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
                                        <th scope="col" width="2%">#</th>
                                    </tr>
                                </thead>
                                <tbody id="body_premium">
                                </tbody>
                            </table>
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
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:130px">การชำระเงิน</span>
                                    </div>

                                    <select class="form-control" name="Payment_Sell" id="Payment_Sell" style="border-radius: 0px 10px 10px 0px;" required>
                                        <option value="">เลือกประเภทการชำระ </option>
                                        @foreach($payments as $payment)
                                        <option value="{{$payment->Id_Payment}}">{{$payment->Name_Payment}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="input-group col-sm-3 ">


                                </div>
                                <div class="input-group col-sm-4 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:130px">รับเงิน :</span>
                                    </div>
                                    <input type="number" class="form-control text-center Member_Pay" name="Member_Pay" id="Member_Pay" min="0" value="0">
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
                                    <input type="text" class="form-control text-center total" name="total" id="total" value="0.00" style="background-color: #E8ECEE;  " readonly>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="background-color: #c1c1c1;color:black; border-radius: 0px 10px 10px 0px;"> บาท</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 ">

                                </div>
                                <div class="input-group col-sm-4 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:130px">เงินทอน :</span>
                                    </div>
                                    <input type="text" class="form-control text-center Member_Pay" name="coin" id="coin" value="" readonly>
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
                                    <input type="text" class="form-control text-center discount_member" name="discount_member" id="discount_member" value="-" style="background-color: #E8ECEE;  " readonly>
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
                                    <input type="text" class="form-control text-center payment " value="0.00" name="payment" id="payment" style="background-color: #E8ECEE; height:40px " readonly>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="background-color: #c1c1c1;color:black; border-radius: 0px 10px 10px 0px;"> บาท</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 ">

                                </div>
                                <div class="col-sm-4">

                                    <button type="submit" name="Enter_Sell" id="Enter_Sell" class="btn btn-primary Enter_Sell" onclick="confirmalert( event );" style="width:100%; height:40px; background-color: #42A667; border-color: #42A667; border-radius: 10px;" disabled><i class="fas fa-cash-register fa-2x"></i> </button>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-sm-5 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:130px">vat 7 % :</span>
                                    </div>
                                    <input type="text" class="form-control text-center vat " value="0.00" name="vat" id="vat" style="background-color: #E8ECEE; height:40px " readonly>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="background-color: #c1c1c1;color:black; border-radius: 0px 10px 10px 0px;"> บาท</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 ">

                                </div>
                                <div class="col-sm-4">



                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="input-group col-sm-5 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:130px">ราคาถอดvat :</span>
                                    </div>
                                    <input type="text" class="form-control text-center vat1 " value="0.00" name="vat1" id="vat1" style="background-color: #E8ECEE; height:40px " readonly>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="background-color: #c1c1c1;color:black; border-radius: 0px 10px 10px 0px;"> บาท</span>
                                    </div>
                                </div>
                                <div class="col-sm-3 ">

                                </div>
                                <div class="col-sm-4">



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
                                    <td> {{$product->Id_Product}}
                                        <input type="hidden" class="Id_Lot" value="{{$product->Id_Lot}}" name="Id_Lot[]">
                                    </td>
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
                                        <input type="hidden" class="Id_Brand_Product " value="{{$product->Brand_Id}}" name="Id_Brand_Product[]">
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
                                        @if(($product->Amount_Lot - $product->Amount_Preorder) <= 0) <div style="color:red"> 0<input type="hidden" class="form-control text-center noHover" value=" 0" name="Amount_Sell[]">
                    </div>
                    @else
                    {{$product->Amount_Lot - $product->Amount_Preorder}}
                    <input type="hidden" class="form-control text-center noHover" value="{{$product->Amount_Lot - $product->Amount_Preorder}}" name="Amount_Sell[]">
                    @endif


                    </td>
                    <td>
                        @foreach($promotions as $promotion)
                        @if($product->Id_Product == $promotion->Id_Product)
                        <button type="button" class="btn btn-warning ID_Promotion_Product " id="{{$promotion->Id_Promotion}} " style="border-radius: 5px;  " data-toggle="modal" data-target="#myModal_Promotion_De_1"> <i class="fas fa-eye"></i></button>
                        <input type="hidden" value="{{$promotion->Id_Promotion}} " name="Id_Promotion_Product_inp[]">
                        <input type="hidden" value="{{$product->Price}} " name="Price_Product[]">
                        @endif
                        @endforeach
                    </td>



                    <td> <button type="button" class="btn btn-primary buttonID_Product" id="{{$product->Id_Product}}" style="border-radius: 5px; width: 120px; " data-toggle="modal" data-target="#myModalOffer"> <i class="fas fa-cart-arrow-down" style="margin-right: 5px;"></i> เลือกสินค้า</button></td>
                    <input type="hidden" value="{{$product->Price}} " name="Price_Product[]">
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
                        <h5 id="exampleModalLabel" class="modal-title"><i class="fas fa-star" style="color:#F0B71A; padding-right: 8px; "></i>รายละเอียดโปรโมชั่นของแถม</h5>
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





    function confirmalert(e) {
        e.preventDefault();
        var frm = e.target.form;

        var Payment = $('#Payment_Sell').val();

        if (Payment == "PYM-202104-001") {
            swal({
                title: "",
                text: "ตรวจสอบสลิปการโอนจากลูกค้า ?",
                icon: "success",
                buttons: ['ยังไม่พร้อมโอน', 'โอนเงินแล้ว'],
                dangerMode: true,

            }).then(function(isConfirm) {
                if (isConfirm) {
                    swal("ชำระเงินสำเร็จ!", {
                        icon: "success",
                    });
                    frm.submit(); // <--- submit form programmatically
                } else {
                    swal("ลูกค้ายังไม่พร้อมโอน !", "กรุณารอสลิปการโอนจากลูกค้า", "error");
                }
            })
        } else {
            swal("ชำระเงินสำเร็จ!", {
                icon: "success",
            });
            frm.submit();
        }


    }

    // $(document).on('submit', '.Enter_Sell', function() {


    //     alert('wwwww')
    // })




    $(document).on('click', '#tags', function() {
        $('#s_product').click();
    })
    $("#Member_Pay").on("change", function() {
        var payment = $(".payment").val();
        // var ret = "data-123".replace('data-','');
        var payment_re = payment.replace(',', '');
        var Member_Pay = $(this).val();
        var payment_con = parseFloat(payment_re);
        var Member_Pay_con = parseFloat(Member_Pay);

        // console.log(payment_con);
        // console.log(Member_Pay_con);

        if (payment_con <= Member_Pay_con) {
            // document.getElementById('Enter_Sell').disabled = true;
            var coin = Member_Pay_con - payment_con;

            $(':input[type="submit"]').prop('disabled', false);
            // console.log(coin + 'เงินทอน');
            $('#coin').val(coin);
        } else {
            $(':input[type="submit"]').prop('disabled', true);
            // console.log(Member_Pay_con + 'ยังไม่ครบ');

        }

        // alert(payment);
    });


    $("#payment").on("change", function() {
        var payment = $("#payment").val();
        // var ret = "data-123".replace('data-','');
        var payment_re = payment.replace(',', '');

        var payment_con = parseFloat(payment_re);
        alert(payment);


        // $('input[name="vat"]').val(payment_con);

        // console.log(payment_con);
        // console.log(Member_Pay_con);

        // if (payment_con <= Member_Pay_con) {
        //     // document.getElementById('Enter_Sell').disabled = true;
        //     var coin = Member_Pay_con - payment_con;

        //     $(':input[type="submit"]').prop('disabled', false);
        //     // console.log(coin + 'เงินทอน');
        //     $('#coin').val(coin);
        // } else {
        //     $(':input[type="submit"]').prop('disabled', true);
        //     // console.log(Member_Pay_con + 'ยังไม่ครบ');

        // }

        // alert(payment);
    });





    function chk_value() {

        var enabled = document.getElementById('radioCustom2').checked;

        if (enabled == false) {
            document.getElementById('member').value = "";
            document.getElementById('id_member').value = "";
            document.getElementById('discount_member').value = "-";
        }

        document.getElementById('member').readonly = !enabled;
        document.getElementById('s_member').disabled = !enabled;
        let total_ = sumTotal();

        $('#total').val(total_.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
        let payment_ = sumPayment();
        $('#payment').val(payment_.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));

        // (document.getElementById('discount_member') = !enabled)



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

        $.ajax({
            url: "{{route('sell.Select_Discount')}}",
            method: "POST",
            data: {
                Id_Member: Id_Member,
                _token: _token
            },
            success: function(result) {

                $('input[name="discount_member"]').val(result);
                let total_ = sumTotal();

                $('#total').val(total_.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
                let payment_ = sumPayment();
                $('#payment').val(payment_.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
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





    function sumTotal() {
        var total_ = 0;
        $('.total_cost').each(function() {
            total_ += parseFloat($(this).val());
        });
        return total_;
    }

    function sumPayment() {
        var payment_ = 0;
        var band = [];
        var price = [];
        $('.total_cost').each(function() {
            payment_ += parseFloat($(this).val());
            price.push($(this).val());
        });

        discount_member = document.getElementById("discount_member").value;
        if (isNaN(discount_member)) {
            discount_member_ = 0;
        } else {
            discount_member_ = parseFloat(discount_member);
        }

        var payment_show = payment_ - ((payment_ * discount_member_) / 100);
        payment_show = Math.ceil(payment_show);

        vat = ((payment_ * 0.07));
        vat1 = ((payment_ - (payment_) * 0.07));
        document.getElementById("vat").value = vat.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
        document.getElementById("vat1").value = vat1.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
        // var Id_Brand = test.find("input[name='Id_Brand[]']").val();
        // alert(Id_Brand);
        var Id_Brand_chk = "";
        var total_chk = "";




        $('.Id_Brand').each(function() {
            band.push($(this).val());

        });
        // console.log(arr);
        var bandAll = [];
        var priceAll = [];
        var testprice = 0;
        for (let i = 0; i < band.length; i++) {
            testprice = parseFloat(price[i]);
            priceAll[i] = testprice;
            bandAll[i] = band[i];
            for (let j = 0; j < band.length; j++) {
                // console.log(i);
                if (i == j) {
                    continue;
                } else if (band[i] == band[j]) {
                    priceAll[i] += parseFloat(price[j]);

                }

            }
        }


        // var Id_Brand_Promo = "";
        $('.Id_Brand_Promotion_Get').each(function() {
            // var chk_payment = false;
            var tr_promotion = $(this).closest('tr');
            var Payment_Amount = tr_promotion.find("input[name='Payment_Amount[]']").val();

            var Payment_Amount_con = parseFloat(Payment_Amount);
            // console.log(Id_Brand_Promo + ' ' + Payment_Amount_con);
            var Id_Brand_Promo = $(this).val();
            var sub_Id_Brand = Id_Brand_Promo.substring(0, 14);

            for (var x in bandAll) {
                var txt_air = document.getElementById('chk_Payment').value;
                // console.log(txt_air);
                if (bandAll[x] == sub_Id_Brand && Math.ceil(parseFloat(priceAll[x] - ((priceAll[x] * discount_member_) / 100))) >= Payment_Amount_con) {

                    var add = Payment_Amount_con += bandAll[x];
                    var chk_txt = txt_air.includes(add);


                    if (document.getElementById("chk_Payment").innerHTML = chk_txt == true) {
                        // swal('มีสินค้าของแถมแล้ว');

                    } else {

                        txt_air += add;

                        $('#chk_Payment').val(txt_air);

                        var _token = $('input[name="_token"]').val();


                        $.ajax({
                            url: "{{route('sell.select_promotion_payment')}}",
                            method: "POST",
                            data: {
                                sub_Id_Brand: sub_Id_Brand,
                                _token: _token
                            },
                            success: function(result) {
                                $('#body_premium').append(result);
                            }
                        });

                        break;
                    }


                }


            }

        });

        return payment_show;
    }

    $(document).on("click", ".buttonID_Product", function() {
        var chk1 = true;
        var value = $(this).parent().parent();
        var Id_Product = $(this).attr("Id");

        var _token = $('input[name="_token"]').val();
        var test = $(this).closest('tr')
        let Id_Promotion_Product = test.find("input[name='Id_Promotion_Product_inp[]']").val();

        let Id_Lot = test.find("input[name='Id_Lot[]']").val();
        // var Id_Brand_Promo = $(this).val();
        var sub_Id_Lot = Id_Lot.substring(0, 14);

        var arr_product = [];
        var arr_lot = [];
        $('.Id_Product_Sell').each(function() {
            arr_product.push($(this).val());

            // if (Id_Product == Id_Product_Sell && Id_Lot == Id_Lot_Product) {
            //     swal('เลือกสินค้าซ้ำ');
            //     chk1 = true;
            //     return false;
            // };

        });
        $('.Id_Lot_Product').each(function() {
            arr_lot.push($(this).val());

            // var sub_Id_Lot_Product = Id_Lot_Product.substring(0, 14);
        });

        for (let i = 0; i < arr_lot.length; i++) {

            if (arr_lot[i] == Id_Lot && arr_product[i] == Id_Product) {
                swal('เลือกสินค้าซ้ำ');
                chk1 = false;
                break;
            }


        }





        var Amount_Sell = value.find("input[name='Amount_Sell[]']").val();

        if (Amount_Sell == 0) {
            swal('สินค้าหมด');
            exit();
        }


        var rowid = $('#body_product tr:last-child').attr('id');

        if (rowid == null || rowid == "") {
            rowid = 1;

        } else {
            rowid = rowid.substr(4);
            rowid++;
        }
        // console.log(rowid);



        if (chk1 == true) {
            if (typeof Id_Promotion_Product === "undefined") {
                $.ajax({
                    url: "{{route('sell.select_Id_Product')}}",
                    method: "POST",
                    data: {
                        Id_Product: Id_Product,
                        Id_Lot: Id_Lot,
                        rowid: rowid,
                        Amount_Sell: Amount_Sell,
                        _token: _token
                    },
                    success: function(result) {
                        $('#body_product').append(result);
                        let total_ = sumTotal();

                        $('#total').val(total_.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));


                        let payment_ = sumPayment();
                        $('#payment').val(payment_.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));



                    }
                });

                $.ajax({
                    url: "{{route('sell.select_Promotion_Product')}}",
                    method: "POST",
                    data: {
                        rowid: rowid,
                        _token: _token
                    },
                    success: function(result) {
                        $('#body_premium').append(result);
                    }
                });
            } else {


                // swal(Id_Promoiton_Product);
                $.ajax({
                    url: "{{route('sell.select_Id_Product')}}",
                    method: "POST",
                    data: {

                        Id_Product: Id_Product,
                        Id_Lot: Id_Lot,
                        Amount_Sell: Amount_Sell,
                        rowid: rowid,
                        _token: _token
                    },
                    success: function(result) {
                        // $('.show_product').append(result);

                        $('#body_product').append(result);
                        // console.log(result);
                        let total_ = sumTotal();

                        $('#total').val(total_.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));
                        let payment_ = sumPayment();
                        $('#payment').val(payment_.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));

                    }
                });

                $.ajax({
                    url: "{{route('sell.select_Promotion_Product')}}",
                    method: "POST",
                    data: {
                        Id_Lot: Id_Lot,
                        rowid: rowid,
                        Id_Promotion_Product: Id_Promotion_Product,
                        _token: _token
                    },
                    success: function(result) {
                        $('#body_premium').append(result);
                    }
                });

            }
        };

        // var job = $('#' + penis_test + ' td:nth-child(2)').html();




    });





    $(document).on("change", ".the_input_approve", function() {

        let test = $(this).closest('tr')
        let input_approve = test.find('.the_input_approve').val();
        let input_cost = test.find('.the_input_cost').val();
        // var  b = parseInt(input_cost);

        var rowid = $(this).parents('tr').attr('id');

        rowid = rowid.substr(4);

        // var input_approvemyJSON = JSON.stringify(input_approve);
        // var input_costmyJSON = JSON.stringify(input_cost);

        // test.find('.total_cost').val(input_cost * input_approve);
        // new Intl.NumberFormat().format()
        // .toLocaleString()


        var Id_Product = $('.Id_Product_Sell').val();

        var Show_Amount = $('.Show_Amount_Premium').val();
        var Lot_Premium = $('.Lot_Premium').val();
        var No = 0;
        if (Show_Amount >= Lot_Premium) {
            swal('สินค้าของแถมหมด');
            $('#Show_Amount_Premium').val(Lot_Premium);

        } else {

            $('.rows' + rowid).each(function() {
                console.log(rowid);
                No++;
                var varcount = $('.' + rowid + '.Premium_Pro' + No).val();

                $('.' + rowid + '.No' + No).val(input_approve * varcount);


            });
        }




        test.find('.total_cost_s').val((input_approve * input_cost).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
        test.find('.total_cost').val((input_approve * input_cost));

        let total_ = sumTotal();

        $('#total').val(total_.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
        let payment_ = sumPayment();
        $('#payment').val(payment_.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));



        var band = [];
        var price = [];
        $('.Id_Brand').each(function() {

            band.push($(this).val());
        });
        $('.total_cost').each(function() {

            price.push($(this).val());
        });


        var bandAll = [];
        var priceAll = [];
        var testprice = 0;
        for (let i = 0; i < band.length; i++) {
            testprice = parseFloat(price[i]);
            priceAll[i] = testprice;
            bandAll[i] = band[i];
            for (let j = 0; j < band.length; j++) {
                // console.log(i);
                if (i == j) {
                    continue;
                } else if (band[i] == band[j]) {
                    priceAll[i] += parseFloat(price[j]);

                }

            }
        }
        // console.log(bandAll);
        // console.log(priceAll);
        $('.Id_Brand_Promotion_Get').each(function() {
            // var chk_payment = false;
            var tr_promotion = $(this).closest('tr');
            var Payment_Amount = tr_promotion.find("input[name='Payment_Amount[]']").val();

            var Payment_Amount_con = parseFloat(Payment_Amount);
            // console.log(Id_Brand_Promo + ' ' + Payment_Amount_con);
            var Id_Brand_Promo = $(this).val();
            var sub_Id_Brand = Id_Brand_Promo.substring(0, 14);

            for (var x in bandAll) {
                // console.log(txt_air);
                if (bandAll[x] == sub_Id_Brand && Math.ceil(parseFloat(priceAll[x] - ((priceAll[x] * discount_member_) / 100))) < Payment_Amount_con) {

                    $('.Id_Brand_Pay_Remove').each(function() {
                        var Id_Brand_Pay_Remove = $(this).val();
                        var sub_Id_Brand_Pay_Remove = Id_Brand_Pay_Remove.substring(0, 14);
                        if (Id_Brand_Pay_Remove == bandAll[x]) {
                            // console.log('ต่ำกว่ายอด' + bandAll[x]);
                            $(this).parent().parent().remove();
                            $('.' + bandAll[x]).remove();
                            // var ret = "data-123".replace('data-','');

                            var txtair_ = document.getElementById("chk_Payment").value;
                            var delete_txt = Payment_Amount_con += bandAll[x];
                            var ret = txtair_.replace(delete_txt, "");
                            document.getElementById("chk_Payment").value = "";
                            $('#chk_Payment').val(ret);


                        }
                    });


                }


            }

        });



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
        var _token = $('input[name= "_token"]').val();
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

    $(document).on('click', '.remove', function() {


        var rowid = $(this).parents('tr').attr('id');

        rowid = rowid.substr(4);
        $('#rowp' + rowid).remove();

        $('.rows' + rowid).remove();



        // $('.Id_Product_Remove').each(function() {
        //     var Id_Product_Remove = $(this).val();

        //     if (Id_Product_Sells == Id_Product_Remove) {
        //         $(this).parent().parent().remove();
        //     };
        // });

        // if (Id_Product_Sells == Id_Product_Remove) {
        //     $('.Id_Product_Remove').parent().remove();
        // }
        // $(this).parent().parent().remove();



        let total_ = sumTotal();

        $('#total').val(total_.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
        let payment_ = sumPayment();
        $('#payment').val(payment_.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));


        var band = [];
        var price = [];
        $('.Id_Brand').each(function() {

            band.push($(this).val());
        });
        $('.total_cost').each(function() {

            price.push($(this).val());
        });


        var bandAll = [];
        var priceAll = [];
        var testprice = 0;
        for (let i = 0; i < band.length; i++) {
            testprice = parseFloat(price[i]);
            priceAll[i] = testprice;
            bandAll[i] = band[i];
            for (let j = 0; j < band.length; j++) {
                // console.log(i);
                if (i == j) {
                    continue;
                } else if (band[i] == band[j]) {
                    priceAll[i] += parseFloat(price[j]);

                }

            }
        }
        // console.log(bandAll);
        // console.log(priceAll);
        $('.Id_Brand_Promotion_Get').each(function() {
            // var chk_payment = false;
            var tr_promotion = $(this).closest('tr');
            var Payment_Amount = tr_promotion.find("input[name='Payment_Amount[]']").val();

            var Payment_Amount_con = parseFloat(Payment_Amount);
            // console.log(Id_Brand_Promo + ' ' + Payment_Amount_con);
            var Id_Brand_Promo = $(this).val();
            var sub_Id_Brand = Id_Brand_Promo.substring(0, 14);

            for (var x in bandAll) {
                // console.log(txt_air);
                if (bandAll[x] == sub_Id_Brand && Math.ceil(parseFloat(priceAll[x] - ((priceAll[x] * discount_member_) / 100))) < Payment_Amount_con) {

                    $('.Id_Brand_Pay_Remove').each(function() {
                        var Id_Brand_Pay_Remove = $(this).val();
                        var sub_Id_Brand_Pay_Remove = Id_Brand_Pay_Remove.substring(0, 14);
                        if (Id_Brand_Pay_Remove == bandAll[x]) {
                            // console.log('ต่ำกว่ายอด' + bandAll[x]);
                            $(this).parent().parent().remove();
                            $('.' + bandAll[x]).remove();
                            // var ret = "data-123".replace('data-','');

                            var txtair_ = document.getElementById("chk_Payment").value;
                            var delete_txt = Payment_Amount_con += bandAll[x];
                            var ret = txtair_.replace(delete_txt, "");
                            document.getElementById("chk_Payment").value = "";
                            $('#chk_Payment').val(ret);


                        }
                    });


                }


            }

        });



    });
</script>


@endsection
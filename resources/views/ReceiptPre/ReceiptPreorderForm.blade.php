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
    <form action="/ReceiptPre/storeReceiptPreorder" method="POST" enctype="multipart/form-data">
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h1 display">รับสินค้าสั่งจอง</h1>
            </header>
            <textarea id="chk_Payment" name="chk_Payment" rows="10" hidden>

            </textarea>
            <div class="row">
                @foreach($preorders as $preorder)
                <div class="col">
                    <div class="card">
                        <div class="card-header  align-items-center">

                            <div class="form-group row">
                                <div class="input-group col-sm-2">

                                </div>

                                <div class="input-group col-sm-2">

                                </div>
                                <div class="input-group col-sm-1">

                                </div>
                                <div class="input-group col-sm-1">

                                </div>
                                <div class="input-group col-sm-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default">วันที่ :</span>
                                    </div>
                                    <input type="text" class="form-control" name="date_sell" id="date_sell" value="<?php echo date('Y-m-d'); ?>" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px;" readonly>
                                </div>
                                <div class="input-group col-sm-3 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default">เวลา :</span>
                                    </div>
                                    <input type="text" class="form-control" name="Time" id="Time" value="<?php echo date('H:i:s'); ?>" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px;" readonly>
                                </div>
                            </div>
                            <div class="form-group row">



                                <div class="input-group col-sm-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default">ชื่อลูกค้า :</span>
                                    </div>
                                    <input type="hidden" class="form-control text-center noHover Id_Product " value="{{$preorder->Id_Preorder}}" name="Id_Preorder">
                                    <input type="text" class="form-control a1 text-center" id="member" name="member" value="{{$preorder->FName_Member}}" style="background-color: #E8ECEE; border-radius: 0px 10px 10px 0px;" readonly>
                                </div>
                                <div class="input-group col-sm-2">

                                </div>
                                <div class="input-group col-sm-1 ">

                                </div>
                                <div class="input-group col-sm-3">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default">วันที่นัดรับ :</span>
                                    </div>
                                    <input type="text" class="form-control" name="date_receipt" id="date_receipt" value="{{substr($preorder->Receive_date,0,10)}}" style=" border-radius: 0px 10px 10px 0px;" required>
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
                @endforeach
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
                                        <th scope="col" width="5%">ระยะประกัน</th>
                                        <th scope="col" width="5%">จำนวน</th>
                                        <th scope="col" width="5%">เงินมัดจำแล้ว</th>
                                        <th scope="col" width="5%">ส่วนที่เหลือ</th>
                                        <th scope="col" width="5%">ราคารวม</th>
                                    </tr>

                                </thead>
                                <tbody id="body_product">
                                    @foreach($preorder_lists as $preorder_list)
                                    <tr>
                                        <td scope="row" width="6%"><img src="{{asset('storage')}}/Products_image/{{$preorder_list->Img_Product}}" width="80px" height="90px" alt=""></td>
                                        <td scope="row" width="9%">{{$preorder_list->Name_Product}}
                                            <input type="hidden" class="form-control text-center noHover Id_Product " value="{{$preorder_list->Id_Product}}" name="Id_Product_Preorder[]">
                                        </td>
                                        <td width="5%">
                                            {{$preorder_list->Name_Brand}}
                                        </td>
                                        <?php
                                        $Insurance_data = 0;
                                        $Insurance_data = $preorder_list->Insurance;
                                        // dd($Insurance_data);
                                        // var_dump(strtotime($Insurance));
                                        $strStartDate = date('Y-m-d');
                                        $datadate = date("Y-m-d", strtotime("+" . $Insurance_data . " day", strtotime($strStartDate)));
                                        // dd($datadate);

                                        ?>
                                        @if($preorder_list->Insurance == "0")
                                        <td scope="row" width="5%"><input type="text" class="form-control text-center noHover Insurance_s" value="ไม่มีประกัน" readonly>
                                            <input type="hidden" class="form-control text-center noHover  Insurance" value="{{$strStartDate}}" name="Insurance[]">
                                        </td>
                                        @else
                                        <td scope="row" width="5%"><input type="text" class="form-control text-center noHover Insurance_s" value="{{$datadate }}" readonly>

                                            <input type="hidden" class="form-control text-center noHover  Insurance" value="{{$datadate }}" name="Insurance[]">
                                        </td>
                                        @endif






                                        <td width="5%">{{$preorder_list->Amount_Preorder}}
                                            <input type="hidden" class="form-control text-center noHover Id_Product " value="{{$preorder_list->Amount_Preorder}}" name="Amount_Preorder[]">
                                        </td>
                                        <td width="5%">{{number_format($preorder_list->Deposit,2)}}
                                            <input type="hidden" class="form-control text-center noHover Id_Product " value="{{$preorder_list->Deposit}}" name="Amount_Preorder[]">
                                        </td>
                                        <td width="5%">{{number_format($preorder_list->Amount,2)}}
                                            <input type="hidden" class="form-control text-center noHover Id_Product " value="{{$preorder_list->Amount}}" name="Amount_Preorder[]">
                                        </td>
                                        <td width="5%">{{number_format($preorder_list->Price,2)}}
                                            <input type="hidden" class="form-control text-center noHover Id_Product " value="{{$preorder_list->Price}}" name="Amount_Preorder[]">
                                        </td>

                                    </tr>
                                    @endforeach
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

                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:130px">ยอดชำระ :</span>
                                    </div>
                                    <input type="text" class="form-control text-center payment " value="{{number_format($sum,2)}}" name="payment" id="payment" style="background-color: #E8ECEE; height:40px " readonly>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="background-color: #c1c1c1;color:black; border-radius: 0px 10px 10px 0px;"> บาท</span>
                                    </div>


                                </div>
                                <div class="input-group col-sm-4 ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="width:130px">ส่วนที่เหลือ :</span>
                                    </div>
                                    <input type="text" class="form-control text-center Deposit_Show" name="Deposit_Show" id="Deposit_Show" value="{{number_format($sum_deposit,2)}}" readonly>
                                    <input type="hidden" class="form-control text-center noHover Id_Product " name="Deposit_insert" id="Deposit_insert" value="{{$sum_deposit}}" name="Id_Preorder">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default" style="background-color: #c1c1c1;color:black; border-radius: 0px 10px 10px 0px;"> บาท</span>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="input-group col-sm-5 ">

                                </div>
                                <div class="col-sm-3 ">

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

                                </div>
                                <div class="col-sm-3 ">

                                </div>
                                <div class="col-sm-4">

                                    <button type="submit" name="Enter_Sell" id="Enter_Sell" class="btn btn-primary " onclick="confirmalert( event );" style="width:100%; height:40px; background-color: #42A667; border-color: #42A667; border-radius: 10px;" disabled><i class="fas fa-cash-register fa-2x"></i> </button>

                                </div>
                            </div>
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

    });

    function confirmalert(e) {
        e.preventDefault();
        var frm = e.target.form;

        var Payment = $('#Payment_Sell').val();
        // alert(Payment)

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




    $(document).on('change', '#Deposit', function() {
        if (Deposit == '') {
            $(this).val(0);
        }
        var Deposit = parseFloat($(this).val());
        var payment = $('#payment').val();
        var payment_re = payment.replace(',', '');
        payment_re = parseFloat(payment_re);



        Deposit = (payment_re / 100) * Deposit;



        $('#Deposit_Show').val(Math.ceil(Deposit));
        // alert(Deposit);
    });




    $(document).on('click', '#tags', function() {
        $('#s_product').click();
    })
    $("#Member_Pay").on("change", function() {
        var Deposit_Show = $(".Deposit_Show").val();


        var Deposit_Show_Re = Deposit_Show.replace(',', '');
        var Member_Pay = $(this).val();
        var Deposit_Show_Con = parseFloat(Deposit_Show_Re);
        var Member_Pay_con = parseFloat(Member_Pay);




        if (Deposit_Show_Con <= Member_Pay_con) {

            var coin = Member_Pay_con - Deposit_Show_Con;


            $(':input[type="submit"]').prop('disabled', false);

            $('#coin').val(coin);
        } else {
            $(':input[type="submit"]').prop('disabled', true);


        }


    });
</script>


@endsection
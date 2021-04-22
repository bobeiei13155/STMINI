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
    <form action="/Claim/storeClaim" method="post" enctype="multipart/form-data">
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

                                <div class="  " style="padding-top: 10px; padding-right: 10px ;padding-left: 15px ; ">

                                    <h2>เลือกใบเสร็จ :<h2>

                                </div>
                                <div class="input-group col-sm-3 ">
                                    <div class="input-group-prepend">
                                        <button type="button" data-toggle="modal" data-target="#myModal_Product" class="input-group-text " id="s_product" id="inputGroup-sizing-default" style="background-color: #42A667;color:#FFF; border-radius: 10px 0px 0px 10px; height:40px;"><i class="fas fa-search"></i></button>
                                    </div>
                                    <input type="text" class="form-control" id="tags" value="" style="background-color: #FFF; border-radius: 0px 10px 10px 0px;" readonly>
                                </div>
                                <div class="input-group col-sm-2">

                                </div>
                                <div class="input-group col-sm-1">

                                </div>
                                <div class="input-group col-sm-2">

                                </div>



                                <div class="input-group col-sm-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text a1" id="inputGroup-sizing-default">พนักงานที่รับเคลม :</span>
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
            </div>
            <div class="col-sm-4">

                <button type="submit" name="Enter_Sell" id="Enter_Sell" class="btn btn-primary " style="width:100%; height:40px; background-color: #42A667; border-color: #42A667; border-radius: 10px;" disabled><i class="fas fa-cash-register fa-2x"></i> </button>

            </div>
        </div>

        <!-- Modal_Product-->
        <div id="myModal_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog modal-lg">
                <div class="modal-content" style="width: auto;">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">สินค้า</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <table class="table text-center" id="table_product" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>รหัสใบเสร็จ</th>
                                    <th>ชื่อพนักขาย</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>ดูรายละเอียดห</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sells as $sell)
                                <tr>
                                    <td> {{$sell->Id_Sell}}
                                        <input type="hidden" class="Id_Lot" value="{{$sell->Id_Sell}}" name="Id_Sell[]">
                                    </td>
                                    <td> {{$sell->FName_Emp}}</td>
                                    <td> {{$sell->FName_Member}}</td>
                                    <td> <button type="button" class="btn btn-info Id_Sell " id="{{$sell->Id_Sell}} " value="{{$sell->Id_Sell}} " data-toggle="modal" data-target="#myModal" class="input-group-text " style="border-radius: 5px;  "> <i class="fas fa-eye"></i></button></td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>


            <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog modal-lg">
                    <div class="modal-content" style="width: auto;">
                        <div class="modal-header">
                            <h5 id="exampleModalLabel" class="modal-title">รายละเอียดใบเสร็จ</h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">

                            <table class="table text-center" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="9%">ชื่อสินค้า</th>
                                        <th width="6%">จำนวนที่ซื้อ</th>
                                        <th width="6%">ระยะเวลาประกัน</th>
                                        <th width="2%">เลือก</th>
                                    </tr>
                                </thead>
                                <tbody class="Show_Product">

                                </tbody>
                            </table>

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

    });


    $(document).on('click', '#tags', function() {
        $('#s_product').click();
    })

    $(document).on("click", ".select_Id_Product", function() {
        var index = $(this).closest('tr');
        var Id_Sell = $(this).attr("Id");
        var _token = $('input[name="_token"]').val();
        var Id_Product = index.find('input[name="Id_Product_Sell"]');

        swal(Id_Product);
        // var job = $('#' + penis_test + ' td:nth-child(2)').html();
        // $.ajax({
        //   url: "{{route('sell.Detail_Sell')}}",
        //   method: "POST",
        //   data: {
        //     Id_Sell: Id_Sell,
        //     _token: _token
        //   },
        //   success: function(result) {
        //     $('.Show_Sell').html(result);

        //   }
        // })
    });





    $(document).on("click", ".Id_Sell", function() {

        var Id_Sell = $(this).attr("Id");

        var _token = $('input[name="_token"]').val();
        // swal(Id_Member);
        // var job = $('#' + penis_test + ' td:nth-child(2)').html();
        $.ajax({
            url: "{{route('Claim.select_Id_Sell')}}",
            method: "POST",
            data: {
                Id_Sell: Id_Sell,
                _token: _token
            },
            success: function(result) {

                $('.Show_Product').html(result);
            }
        })



    });
</script>


@endsection
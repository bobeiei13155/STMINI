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
<style>

</style>
<section class="forms">
    <form action="/Stminishow/storeOffer" method="post" enctype="multipart/form-data">
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h1 display">เพิ่มเสนอสั่งซื้อสินค้า</h1>
            </header>
            <div class="row">
                <div class="col-sm">
                    <div class="card">
                        <div class="card-header  align-items-center">

                            <div class="form-group row">
                                <label class="col-auto col-form-label">
                                    <h5>ID :</h5>
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="Id_Offer" value="{{session()->get('Id_Offer')}}" disabled>
                                </div>
                                <label class="col-auto col-form-label">
                                    <h5>ชื่อผู้เสนอ :</h5>
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="{{session()->get('fname')}}" disabled>
                                </div>
                                <label class="col-auto col-form-label">
                                    <h5>วันที่เสนอ :</h5>
                                </label>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" name="Offer_date" id="Offer_date" required>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" data-toggle="modal" data-target="#myModal_Product" class="col-auto btn btn-info  float-right"> <i class="fas fa-shopping-bag" style="margin-right: 5px;"></i> สินค้าต่ำกว่าจุดสั่งซื้อ </button>
                                </div>
                                <div class="col">
                                    <button type="button" data-toggle="modal" data-target="#myModal" class="col-auto btn btn-primary  float-right"> <i class="fas fa-shopping-bag" style="margin-right: 5px;"></i> เลือกสินค้า </button>
                                </div>
                            </div>
                            <!-- Modal-->
                            <div id="myModal_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                                <div role="document" class="modal-dialog modal-lg">
                                    <div class="modal-content" style="width: auto;">
                                        <div class="modal-header">
                                            <h5 id="exampleModalLabel" class="modal-title">สินค้าต่ำกว่าจุดสั่งซื้อ</h5>
                                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">

                                            <table class="table text-center" id="table_product_s" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>ชื่อสินค้า</th>
                                                        <th>ประเภทสินค้า</th>
                                                        <th>ยี่ห้อสินค้า</th>
                                                        <th>GEN</th>
                                                        <th>สินค้าต่ำกว่าจุดสั่งซื้อ</th>
                                                        <th>สินค้าในคลัง</th>
                                                        <th>เลือกสินค้า</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($product_s as $product_)
                                                    <tr>
                                                        <td>{{$product_->Name_Product}}</td>
                                                        <td>

                                                            {{$product_->Name_Category}}

                                                        </td>
                                                        <td>

                                                            {{$product_->Name_Brand}}

                                                        </td>
                                                        <td>

                                                            {{$product_->Name_Gen}}

                                                        </td>
                                                        <td>
                                                            {{$product_->Purchase}}
                                                        </td>
                                                        @if($product_->Purchase >= $product_->Amount_Lot)
                                                            <td style="color:red">

                                                                {{$product_->Amount_Lot}}

                                                            </td>
                                                            @else
                                                            <td >

                                                                {{$product_->Amount_Lot}}

                                                            </td>
                                                            @endif
                                                            <td> <button type="button" class="btn btn-primary buttonID" id="{{$product_->Id_Product}}" style="border-radius: 5px; width: 120px; " data-toggle="modal" data-target="#myModalOffer"> <i class="fas fa-cart-arrow-down" style="margin-right: 5px;"></i> เลือกสินค้า</button></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal-->
                            <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                                <div role="document" class="modal-dialog modal-lg">
                                    <div class="modal-content" style="width: auto;">
                                        <div class="modal-header">
                                            <h5 id="exampleModalLabel" class="modal-title">เลือกสินค้าเสนอสั่งซื้อ</h5>
                                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">

                                            <table class="table text-center" id="table" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>ชื่อสินค้า</th>
                                                        <th>ประเภทสินค้า</th>
                                                        <th>ยี่ห้อสินค้า</th>
                                                        <th>GEN</th>
                                                        <th>เลือกสินค้า</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($products as $product)
                                                    <tr>
                                                        <td>{{$product->Name_Product}}</td>
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
                                                        <td> <button type="button" class="btn btn-primary buttonID" id="{{$product->Id_Product}}" style="border-radius: 5px; width: 120px; " data-toggle="modal" data-target="#myModalOffer"> <i class="fas fa-cart-arrow-down" style="margin-right: 5px;"></i> เลือกสินค้า</button></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- // -->
                            <div id="myModalOffer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                                <div role="document" class="modal-dialog modal-lg">
                                    <div class="modal-content" style="width: auto;">
                                        <div class="modal-header">
                                            <h5 id="exampleModalLabel" class="modal-title">เลือกสินค้าเสนอสั่งซื้อ</h5>
                                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">

                                            <table class="table text-center" id="table" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>ชื่อบริษัท</th>
                                                        <th>ราคาทุน</th>
                                                        <th>เลือกบริษัท</th>

                                                    </tr>
                                                </thead>
                                                <tbody class="show_partner">



                                                </tbody>

                                            </table>
                                            <br>
                                            <button type="button" class="btn btn-info buttonID_Partner" id="save_value" style="border-radius: 5px; width: 100%; "> <i class="fas fa-cart-arrow-down" style="margin-right: 5px;"></i> ยืนยัน</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- //modalpreorder -->
            <div id="myModalPreorder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog modal-lg">
                    <div class="modal-content" style="width: auto;">
                        <div class="modal-header">
                            <h5 id="exampleModalLabel" class="modal-title">เลือกสินค้าเสนอสั่งซื้อ</h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">

                            <table class="table text-center" id="table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ชื่อบริษัท</th>
                                        <th>ราคาทุน</th>
                                        <th>เลือกบริษัท</th>

                                    </tr>
                                </thead>
                                <tbody class="show_partner_preorder">



                                </tbody>

                            </table>
                            <br>
                            <button type="button" class="btn btn-info buttonID_Partner" id="save_value2" style="border-radius: 5px; width: 100%; "> <i class="fas fa-cart-arrow-down" style="margin-right: 5px;"></i> ยืนยัน</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body ">
                            <h4>รายการสั่งจองสินค้า</h4>
                            <table class="table   text-center">
                                <thead>
                                    <tr>
                                        <th scope="col" width="9%">ชื่อสินค้า</th>
                                        <th scope="col" width="9%">จำนวนสินค้า</th>
                                        <th scope="col" width="6%">ราคาทุน</th>

                                    </tr>

                                </thead>
                                @foreach($Preorders as $Preorder)
                                <tr>
                                    <td> {{$Preorder->Name_Product}}</td>
                                    <td> <input type="text" class="form-control text-center Amount_Preorder" value="{{$Preorder->Amount_Preorder}}" name="Amount_Preorder[]" disabled>

                                    </td>
                                    <td> <button type="button" class="btn btn-info buttonID_Preorder" id="{{$Preorder->Id_Product}}" data-toggle="modal" data-target="#myModalPreorder" style="border-radius: 5px; width: 120px; "> <i class="fas fa-cart-arrow-down" style="margin-right: 5px;"></i> เลือกสินค้า</button></td>
                                </tr>
                                @endforeach
                            </table>

                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body ">
                            {{csrf_field()}}


                            <h4>รายการเสนอสั่งซื้อ</h4>
                            <table class="table  table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col" width="9%">ชื่อสินค้า</th>
                                        <th scope="col" width="9%">ชื่อบริษัท</th>
                                        <th scope="col" width="6%">ราคาทุน</th>

                                    </tr>

                                </thead>

                            </table>


                            <div class="showcost">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary " data-dismiss="modal"><span aria-hidden="true"><i class="fas fa-truck"></i> เพิ่มใบเสนอสั่งซื้อสินค้า</span></button>
        </div>

    </form>
</section>

{{csrf_field()}}
<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable({
            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "All"]
            ]
        });
        $('#table_product_s').DataTable({
            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "All"]
            ]
        });
    });

    $(document).on("click", ".buttonID", function() {

        var button_test = $(this).attr("Id");

        var _token = $('input[name="_token"]').val();
        // var job = $('#' + penis_test + ' td:nth-child(2)').html();
        $.ajax({
            url: "{{route('products.select_Partner')}}",
            method: "GET",
            data: {
                button_test: button_test,
                _token: _token
            },
            success: function(show_partner) {

                $('.show_partner').html(show_partner);
            }
        })



    });


    $('#save_value').click(function() {

        var Id_Product = $('input[name="Id_Product[]"]').val();
        var Id_Partner = [];
        var _token = $('input[name="_token"]').val();
        $('.chk2').each(function() {

            // val2[0] = $(this).val();
            // 
            if ($(this).prop("checked") == true) {
                Id_Partner.push($(this).val());
            }

        });
        // alert(Id_Partner);
        $.ajax({
            url: "{{route('products.select_Cost')}}",
            method: "GET",
            data: {
                Id_Product: Id_Product,
                Id_Partner: Id_Partner,
                _token: _token
            },
            success: function(show_cost) {

                $('.showcost').append(show_cost);
            }
        })
        // val = [];


    });

    //สั่งจองสินค้า

    $(document).on("click", ".buttonID_Preorder", function() {

        var Id_Product_Preorder = $(this).attr("Id");
        var test = $(this).closest('tr');
        var Amount_Preorder = test.find('.Amount_Preorder').val();

        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{route('products.select_Partner_Preorder')}}",
            method: "GET",
            data: {
                Id_Product_Preorder: Id_Product_Preorder,
                Amount_Preorder: Amount_Preorder,
                _token: _token
            },
            success: function(show_partner_preorder) {

                $('.show_partner_preorder').html(show_partner_preorder);
            }
        })



    });

    $('#save_value2').click(function() {
        var test = $(this).closest('tr');

        var Id_Product = $('input[name="Id_Product_Preorder[]"]').val();
        var Amount_Preorder = $('input[name="Amount_Preorder[]"]').val();
        var Amount_Preorder_Up = $('input[name="Amount_Preorder_Up[]"]').val();
        var Id_Partner = [];

        var _token = $('input[name="_token"]').val();
        $('.chk3').each(function() {

            // val2[0] = $(this).val();
            // 
            if ($(this).prop("checked") == true) {
                Id_Partner.push($(this).val());
            }

        });
        // alert(Id_Partner);
        $.ajax({
            url: "{{route('products.select_Cost')}}",
            method: "GET",
            data: {
                Id_Product: Id_Product,
                Id_Partner: Id_Partner,
                Amount_Preorder: Amount_Preorder,
                Amount_Preorder_Up: Amount_Preorder_Up,
                _token: _token
            },
            success: function(show_cost) {

                $('.showcost').append(show_cost);
            }
        })
        // val = [];


    });

    // ---------------------------------------------------------------
    // preorder

    $(document).ready(function() {
        $('#table_Preoreder').DataTable({
            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "All"]
            ]
        });
    });

    // ปุ่มลบสินค้า 
    $(document).on('click', '.remove', function() {
        $(this).parent().parent().parent().remove();


    });


    // $('.view_data').change(function() {
    //     if ($(this).val() != '') {
    //         var select = $(this).val();
    //         var _token = $('input[name="_token"]').val();
    //         $.ajax({
    //             url: "{{route('products.select_Product')}}",
    //             method: "POST",
    //             data: {
    //                 select: select,
    //                 _token: _token
    //             },
    //             success: function(result) {
    //                 $('.result').html(result);

    //             }
    //         })
    //     }
    // });

    function Del(id) {
        swal({
                title: "ต้องการลบข้อมูลตำแหน่ง หรือไม่?",
                text: "ตำแหน่ง ID : " + id + " ลบออกจากรายการ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.location = "position.php?Del&id=" + id;
                } else {
                    swal("ยกเลิกการลบข้อมูลสำเร็จ !", {
                        icon: "error",
                    });
                }
            });
    }

    function Edit(id) {
        document.location = "add_position.php?Edit&id=" + id;
    }
</script>
@endsection
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
<section class="forms">
    <form action="/Receipt/store_receipt" method="post" enctype="multipart/form-data">
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h1 display">เพิ่มใบรับสินค้าสั่งซื้อ</h1>
            </header>
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header  align-items-center">

                            <div class="form-group row">
                                <!-- <label class="col-auto col-form-label">
                                    <h5>ID :</h5>
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="Id_Receipt" value="{{session()->get('Id_Receipt')}}" disabled>
                                </div> -->
                                <label class="col-auto col-form-label">
                                    <h5>ชื่อผู้เสนอ :</h5>
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="{{session()->get('fname')}}" disabled>
                                </div>
                                <label class="col-auto col-form-label">
                                    <h5>วันที่เสนอ :</h5>
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="Receipt_date" id="Receipt_date"  value ="<?php echo date('Y-m-d H:i:s'); ?>" readonly>
                                </div>
                                <label class="col-auto col-form-label">
                                    <h5>ใบสั่งซื้อสินค้า :</h5>
                                </label>
                                <div class="col-sm-4">
                                    <select name="Id_Order" id="Id_Order" class="form-control Id_Order" required>
                                        <option value="" selected>เลือกใบสั่งซื้อสินค้า</option>
                                        @foreach($orders as $order)
                                        <option value="{{$order->Id_Order}}">{{$order->Id_Order}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body ">
                            <div class="form-group row">
                                <label class="col-auto col-form-label">
                                    <h5>ชื่อบริษัท : </h5>
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control show_name" name="Name_Partner" id="Name_Partner" readonly>
                                </div>
                            </div>
                            {{csrf_field()}}
                            <table class="table  table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col" width="9%">ชื่อสินค้า</th>
                                        <th scope="col" width="6%">ราคาทุน</th>
                                        <th scope="col" width="6%">จำนวนที่สั่งซื้อ</th>
                                        <th scope="col" width="6%">จำนวนสินค้าค้างรับ</th>
                                        <th scope="col" width="6%">จำนวนสินค้าที่รับ</th>
                                        <th scope="col" width="6%">ลบ</th>
                                    </tr>

                                </thead>

                            </table>

                            <div class="show_receipt">
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary " data-dismiss="modal"><span aria-hidden="true"><i class="fas fa-truck"></i> เพิ่มใบรับสินค้าสั่งซื้อ</span></button>
        </div>




    </form>
</section>

<script type="text/javascript">
    $('.Id_Order').change(function() {
        if ($(this).val() != '') {
            var Id_Order = $(this).val();
            var _token = $('input[name="_token"]').val();
            // swal(Id_Order);

            $.ajax({
                url: "{{route('receipt.select_receipt')}}",
                method: "POST",
                data: {
                    Id_Order: Id_Order,
                    _token: _token
                },
                success: function(result) {
                    $('.show_receipt').html(result);
                    // alert(result);


                }
            })
        }
    });

    $(document).on('click', '.remove', function() {
        $(this).parent().parent().remove();
    });


    $('.Id_Order').change(function() {
        if ($(this).val() != '') {
            var Id_Order = $(this).val();
            var _token = $('input[name="_token"]').val();
            // swal(Id_Order);

            $.ajax({
                url: "{{route('receipt.name_partner')}}",
                method: "POST",
                data: {
                    Id_Order: Id_Order,
                    _token: _token
                },
                success: function(result) {
                    $('.show_name').val(result).html();
                    // alert(result);


                }
            })
        }
    });
</script>


@endsection
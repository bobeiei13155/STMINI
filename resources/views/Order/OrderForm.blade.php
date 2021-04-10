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
    <form action="/Order/storeOrder" method="post" enctype="multipart/form-data">
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h1 display">เพิ่มสั่งซื้อสินค้า</h1>
            </header>
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header  align-items-center">

                            <div class="form-group row">
                                <label class="col-auto col-form-label">
                                    <h5>ID :</h5>
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="Id_Order" value="{{session()->get('Id_Order')}}" disabled>
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
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" name="Order_date" id="Order_date" required>
                                </div>
                                <label class="col-auto col-form-label">
                                    <h5>บริษัทคู่ค้า :</h5>
                                </label>
                                <div class="col">
                                    <select name="Id_Partner" id="Id_Partner" class="form-control Id_Partner" required>
                                        <option value="" selected>เลือกบริษัทคู่ค้า</option>
                                        @foreach($Id_Partner_J as $Id_Partner_row)
                                        <option value="{{$Id_Partner_row->Id_Partner}}">{{$Id_Partner_row->Name_Partner}}</option>
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

                            {{csrf_field()}}
                            <table class="table  table-hover text-center">
                                <thead>
                                    <tr>
                                        <th scope="col" width="9%">ชื่อสินค้า</th>
                                        <th scope="col" width="6%">ราคาทุน</th>
                                        <th scope="col" width="6%">จำนวนที่อนุมัติ</th>
                                        <th scope="col" width="6%">ราคารวม</th>
                                    </tr>

                                </thead>

                            </table>

                            <div class="show_order">
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary " data-dismiss="modal"><span aria-hidden="true"><i class="fas fa-truck"></i> เพิ่มใบสั่งซื้อสินค้า</span></button>
        </div>




    </form>
</section>

<script type="text/javascript">


    $('.Id_Partner').change(function() {
        if ($(this).val() != '') {
            var Id_Partner = $(this).val();
            var _token = $('input[name="_token"]').val();
            // swal(Id_Partner);

            $.ajax({
                url: "{{route('order.select_order')}}",
                method: "POST",
                data: {
                    Id_Partner: Id_Partner,
                    _token: _token
                },
                success: function(result) {
                    $('.show_order').html(result);
                }
            })
        }
    });

    
</script>


@endsection
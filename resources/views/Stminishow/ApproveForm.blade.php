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
    <form action="/Stminishow/storeApprove" method="post" enctype="multipart/form-data">
        <div class="container-fluid">
            <!-- Page Header-->
            <header>
                <h1 class="h1 display">อนุมัติสั่งซื้อสินค้า</h1>
            </header>
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header  align-items-center">

                            <div class="form-group row">
                                <label class="col-auto col-form-label">
                                    <h4>ID : </h4>
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="Id_Offer" value="@foreach($offers_ids as $offers_id){{$offers_id->Id_Offer}}@endforeach" readonly>
                                </div>
                                <label class="col-auto col-form-label">
                                    <h4>ชื่อผู้เสนอ : </h4>
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="{{session()->get('fname')}}" disabled>
                                </div>
                                <label class="col-auto col-form-label">
                                    <h4>วันที่เสนอ : </h4>
                                </label>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" value="@foreach($offers_date as $offer_date){{$offer_date->Offer_date}}@endforeach" disabled>
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
                                        <th scope="col" width="9%">ชื่อบริษัท</th>
                                        <th scope="col" width="6%">ราคาทุน</th>

                                        <th scope="col" width="6%">จำนวนที่เสนอ</th>
                                        <th scope="col" width="6%">จำนวนที่อนุมัติ</th>
                                        <th scope="col" width="6%">ราคารวม</th>
                                    </tr>

                                </thead>

                            </table>
                            @foreach($join_Products as $join_Product)
                            <table class="table text-center">
                                <tr>
                                    <td scope="row" width="9%"><input type="text" class="form-control text-center noHover" value=" {{$join_Product->Name_Product}} " disabled>
                                        <input type="hidden" class="form-control text-center noHover" value="{{$join_Product->No_Offer}}" name="No_Offer[]">
                                        <input type="hidden" class="form-control text-center noHover" value=" {{$join_Product->Id_Product}}" name="Id_Product[]">
                                    </td>
                                    <td width="9%">
                                        <select name="Id_Partner[]" class="form-control partner">
                                            <option value="">
                                                เลือกบริษัทคู่ค้า
                                            </option>
                                            @foreach($join_Partners as $join_Partner)
                                            @if($join_Partner->Id_Product == $join_Product->Id_Product)

                                            <option value="{{$join_Partner->Id_Partner}}">{{$join_Partner->Name_Partner}}
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </td>

                                    </td>
                                    <td width="6%">
                                        <input type="text" class="form-control text-center costs the_input_cost" value="" name="costs[]" required readonly>
                                    </td>

                                    <td width="6%"> <input type="text" class="form-control text-center " value="{{$join_Product->Amount_Post}}" name="Amount_Post[]" disabled></td>
                                    <td width="6%"> <input type="text" class="form-control text-center the_input_approve" name="amount_Approve[]" required></td>
                                    <td width="6%">
                                        <input type="text" class="form-control text-center total_cost" value="" name="total_cost[]" readonly>
                                    </td>
                                </tr>
                            </table>
                            @endforeach
                            <table class="table text-center">
                                <tr>
                                    <td width="9%"></td>
                                    <td width="9%"></td>
                                    <td width="6%"></td>
                                    <td width="6%"></td>
                                    <td width="6%"></td>
                                    <td width="6%">
                                        <h2>ราคารวมทั้งหมด :<h2>
                                    </td>
                                    <td width="6%">
                                        <input type="text" class="form-control text-center " value="" name="total" id="total" readonly>
                                    </td>
                                </tr>
                            </table>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-info " data-dismiss="modal"><span aria-hidden="true"><i class="fas fa-plus" style="margin-right: 5px;"></i> พิจารณาการสั่งซื้อสินค้า</span></button>
    </form>
</section>

{{csrf_field()}}
<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable();
    });

    $('.partner').change(function() {
        var value = $(this).parent().parent();
        var Id_Product = value.find("input[name='Id_Product[]']").val();
        var select = $(this).val();
        var index_select = $('.partner').index(this);
        var _token = $('input[name="_token"]').val();
        var Id_Offer = $('input[name="Id_Offer"]').val();

        $.ajax({
            url: "{{route('partner.select_Cost_Partner')}}",
            method: "POST",
            data: {
                select: select,
                Id_Product: Id_Product,
                Id_Offer: Id_Offer,
                _token: _token
            },
            success: function(result) {
                //  swal(result);
                JSON.stringify(result);
                $('.costs').eq(index_select).val(result);
            }


        })


    });


    // ปุ่มลบสินค้า 
    $(document).on('click', '.remove', function() {
        $(this).parent().parent().parent().remove();


    });

    $('.the_input_approve').on('keyup', function() {
        let test = $(this).closest('tr')
        let input_approve = test.find('.the_input_approve').val();
        let input_cost = test.find('.the_input_cost').val();
        // alert(input_cost * input_approve);
        test.find('.total_cost').val(input_cost * input_approve);
        // alert(test.find('.total_cost').val(input_cost * input_approve));
        var cnt = 0;

        $('.total_cost').each(function() {

            if (!isNaN($(this).val())) {
                cnt += parseInt($(this).val());

            }
        });
        if (isNaN(cnt)) {
            cnt = parseInt($('.total_cost').val());
        }

        $('#total').val(cnt);

    });
    // $(function() {
    //     var output_element = $('#output_ele');
    //     var output_element1 = $('#output_ele1');

    //     $('#the_input_id').keyup(function() {
    //         updateTotal();
    //     });

    //     $('#the_input_id1').keyup(function() {
    //         updateTotal();
    //     });

    //     var updateTotal = function() {
    //         var index_select = $('.partner').index(this);

    //         var input1 = parseInt($('#the_input_id').val());
    //         var input2 = parseInt($('#the_input_id1').val());
    //         var totals = parseFloat(input1 * input2) || 0;
    //         //parseFloat($('#totals').val()) || 0; 
    //         $('#total').eq(index_select).text(totals);
    //     };

    //     // output_total.text(total);

    // });

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
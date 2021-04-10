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
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="h1 display">แก้ไขบริษัทคู่ค้า </h1>
        </header>
        <div class="row">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header  align-items-center">
                        <h4>ID : {{$partners->Id_Partner}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="/Stminishow/updatePartner/{{$partners->Id_Partner}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="Name_Partner" class="font_green">ชื่อบริษัทคู่ค้า</label>
                                        <input type="text" class="form-control" name="Name_Partner" id="Name_Partner" placeholder="ชื่อบริษัทคู่ค้า" value="{{$partners->Name_Partner}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Address_Partner" class="font_green">ที่อยู่</label>
                                        <input type="text" class="form-control" name="Address_Partner" id="Address_Partner" placeholder="ที่อยู่" value="{{$partners->Address_Partner}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="province" class="font_green">จังหวัด</label>
                                        <div class="form-group">
                                            <select name="Province_Id" id="province" class="form-control province">
                                                <option value="{{$partners->Province_Id}}">
                                                    @foreach($list as $row)
                                                    @if($partners->Province_Id == $row->PROVINCE_ID)
                                                    {{$row->PROVINCE_NAME}}
                                                    @endif
                                                    @endforeach
                                                </option>
                                                @foreach($list as $row)
                                                <option value="{{$row->PROVINCE_ID}}">{{$row->PROVINCE_NAME}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="amphur" class="font_green">อำเภอ</label>
                                        <div class="form-group">
                                            <select name="District_Id" class="form-control amphur">
                                                <option value="{{$partners->District_Id}}">
                                                    @foreach($amphur as $row)
                                                    @if($partners->District_Id == $row->AMPHUR_ID)
                                                    {{$row->AMPHUR_NAME}}
                                                    @endif
                                                    @endforeach
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="district" class="font_green">ตำบล</label>
                                        <div class="form-group">
                                            <select name="Subdistrict_Id" class="form-control district">
                                                <option value="{{$partners->Subdistrict_Id}}">
                                                    @foreach($subdistrict as $row)
                                                    @if($partners->Subdistrict_Id == $row->DISTRICT_ID)
                                                    {{$row->DISTRICT_NAME}}
                                                    @endif
                                                    @endforeach
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="district" class="font_green">รหัสไปรษณีย์</label>
                                        <div class="form-group">
                                            <select name="Postcode_Id" class="form-control postcode">
                                                <option value="{{$partners->Postcode_Id}}">
                                                    @foreach($subdistrict as $row)
                                                    @if($partners->Subdistrict_Id == $row->DISTRICT_ID)
                                                    {{$row->POSTCODE}}
                                                    @endif
                                                    @endforeach
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table" id="tel">
                                            <tr>
                                                <th class="">เบอร์โทรศัพท์</th>
                                                <th> <button type="button" class="btn btn-success addRowTel"><i class="fas fa-plus"></i></button></th>
                                            </tr>
                                            @foreach($telptns as $row)
                                            <tr>
                                                <th>
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" name="Tel_PTN[]" id="Tel_PTN" value="{{$row->Tel_PTN}}" placeholder="เบอร์โทรศัพท์" maxlength="10" onkeypress="return onlyNumberKey(event)">
                                                    </div>
                                                </th>
                                                <th> <button type="button" class="btn btn-danger remove"><i class="fas fa-minus"></i></button></th>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="col">
                                        <table class="table table-borderd" id="costs">
                                            <tr>
                                                <th class="font_green th1">สินค้า</th>
                                                <th></th>
                                                <th> <button type="button" class="btn btn-success addRowCosts"><i class="fas fa-plus"></i></button></th>
                                            </tr>
                                            @foreach($costs as $costs)
                                            <tr>
                                                <div class="row">
                                                    <th>
                                                        <div class="col-md- form-group">
                                                            <select class="form-control" name="Id_Product[]">
                                                            <option value="{{$costs->Id_Product}}" selected>{{$costs->Name_Product}}</option>
                                                            </select>
                                                        </div>
                                                    </th>
                                                    <th>
                                                        <div class="col-sm form-group">
                                                            <input type="text" class="form-control" name="cost[]" id="cost" value="{{$costs->Cost}}" placeholder="ราคาทุน" maxlength="10" onkeypress="return onlyNumberKey(event)">
                                                        </div>
                                                    </th>
                                                    <th> <button type="button" class="btn btn-danger remove"><i class="fas fa-minus"></i></button></th>
                                                </div>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" id="submit" class="btn btn-success"> <i class="fas fa-pen" style="margin-right: 5px;"></i>แก้ไข</button>
                            <a class="btn btn-danger my-2" href="/Stminishow/showPartner"> <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>กลับ</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{csrf_field()}}
<script type="text/javascript">
    $('.province').change(function() {
        if ($(this).val() != '') {
            var select = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{route('Employee.f_amphures')}}",
                method: "POST",
                data: {
                    select: select,
                    _token: _token
                },
                success: function(result) {
                    $('.amphur').html(result);
                }
            })
        }
    });
    $('.amphur').change(function() {
        if ($(this).val() != '') {
            var select = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{route('Employee.f_districts')}}",
                method: "POST",
                data: {
                    select: select,
                    _token: _token
                },
                success: function(result) {
                    $('.district').html(result);
                }
            })
        }
    });
    $('.district').change(function() {
        if ($(this).val() != '') {
            var select = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{route('Employee.f_postcode')}}",
                method: "POST",
                data: {
                    select: select,
                    _token: _token
                },
                success: function(result) {
                    $('.postcode').html(result);
                }
            })
        }
    });

    function onlyNumberKey(evt) {


        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
    $('.addRowTel').on('click', function() {
        addRowTel();
    });

    function addRowTel() {
        var addrow = '<tr>' + '<td> <input type="text" class="form-control" name="Tel_Emp[]" id="Tel_Emp" placeholder="เบอร์โทรศัพท์" maxlength="10" onkeypress="return onlyNumberKey(event)"></td>' +
            ' <th> <button type="button"  class="btn btn-danger remove" ><i class="fas fa-minus" ></i></button></th>' + '</tr>'
        $('#tel').append(addrow);
    }

    $(document).on('click', '.remove', function() {
        $(this).parent().parent().remove();
    });
    $('#submit').click(function() {
        //validate form
        $.get('sample-action.php', $('#sample-form').serialize(), function(response) {
            $('#result').html(response);
        });
    });

    $('.addRowCosts').on('click', function() {
        addRowCosts();
    });

    function addRowCosts() {
        var addrow = '<tr>' +
            '     <div class="row">' +
            '<th>' +
            '  <div class="col-md- form-group">' +
            '   <select class="form-control" name="Id_Product[]">' +
            '   <option value="" selected>เลือกสินค้า  </option>' +
            '@foreach($products as $product)' +
            '    <option value="{{$product->Id_Product}}">{{$product->Name_Product}}</option>' +
            '   @endforeach' +
            '       </select>' +
            '   </div>' +
            ' </th>' +
            ' <th>' +
            ' <div class="col-sm form-group">' +
            '   <input type="text" class="form-control" name="cost[]" id="cost" placeholder="ราคาทุน" maxlength="10" onkeypress="return onlyNumberKey(event)">' +
            '</div>' +
            '  </th>' +

            '        <th> <button type="button" class="btn btn-danger remove"><i class="fas fa-minus"></i></button></th>' +
            '   </div>' +
            '</tr>'
        $('#costs').append(addrow);
    }
    $(document).on('click', '.remove', function() {
        $(this).parent().parent().remove();
    });

    $(document).ready(function() {
        $('#Idcard_Emp').on('keyup', function() {
            if ($.trim($(this).val()) != '' && $(this).val().length == 13) {
                id = $(this).val().replace(/-/g, "");
                var result = Script_checkID(id);
                if (result === false) {
                    $('span.error').removeClass('true').text('เลขบัตรผิด').css({
                        'color': '#8ec641'
                    });
                } else {
                    $('span.error').addClass('true').text('เลขบัตรถูกต้อง').css({
                        'color': '#8ec641'
                    });
                }
            } else {
                $('span.error').removeClass('true').text('');
            }
        })
    });

    function Script_checkID(id) {
        if (!IsNumeric(id)) return false;
        if (id.substring(0, 1) == 0) return false;
        if (id.length != 13) return false;
        for (i = 0, sum = 0; i < 12; i++)
            sum += parseFloat(id.charAt(i)) * (13 - i);
        if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12))) return false;
        return true;
    }

    function IsNumeric(input) {
        var RE = /^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;
        return (RE.test(input));
    }
</script>
@endsection
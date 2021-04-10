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
            <h1 class="h1 display">เพิ่มพนักงาน </h1>
        </header>
        <div class="row">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header  align-items-center">
                        <h4>ID : {{Session::get('Id_Emp')}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="/Stminishow/createEmployee" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="FName_Emp" class="font_green">ชื่อ</label>
                                        <input type="text" class="form-control" name="FName_Emp" id="FName_Emp" placeholder="ชื่อ" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="LName_Emp" class="font_green">นามสกุล</label>
                                        <input type="text" class="form-control" name="LName_Emp" id="LName_Emp" placeholder="นามสกุล" required>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="Position_Id" class="font_green">ตำแหน่ง</label>
                                        <select class="form-control" name="Position_Id" required>
                                            <option value="">ตำแหน่ง</option>
                                            @foreach($positions as $position)
                                            <option value="{{$position->Id_Position}}">{{$position->Name_Position}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="Sex_Emp" class="font_green">เพศ</label>
                                        <select class="form-control" name="Sex_Emp">
                                            <option value="" selected>เลือกเพศ</option>
                                            <option value="ชาย">ชาย</option>
                                            <option value="หญิง">หญิง</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="Username_Emp" class="font_green">ชื่อผู้ใช้</label>
                                        <input type="text" class="form-control" name="Username_Emp" id="Username_Emp" placeholder="ชื่อผู้ใช้" minlength="8" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Password_Emp" class="font_green">รหัสผ่าน</label>
                                        <input type="password" class="form-control" name="Password_Emp" id="Password_Emp" placeholder="รหัสผ่าน" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="Address_Emp" class="font_green">ที่อยู่</label>
                                        <input type="text" class="form-control" name="Address_Emp" id="Address_Emp" placeholder="ที่อยู่" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Email_Emp" class="font_green">อีเมล</label>
                                        <input type="email" class="form-control" name="Email_Emp" id="Email_Emp" placeholder="อีเมล" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Idcard_Emp" class="font_green">รหัสบัตรประชาชน</label>
                                        <input type="text" class="form-control" name="Idcard_Emp" id="Idcard_Emp" placeholder="รหัสบัตรประชาชน" maxlength="13" pattern="[0-9]{13}" title="กรุณาให้ให้ครบ 13 ตัว" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="province" class="font_green">จังหวัด</label>
                                        <div class="form-group">
                                            <select name="Province_Id" id="province" class="form-control province" required>
                                                <option value="" selected>เลือกจังหวัด</option>
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
                                                <option value="">เลือกอำเภอ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="district" class="font_green">ตำบล</label>
                                        <div class="form-group">
                                            <select name="Subdistrict_Id" class="form-control district">
                                                <option value="">เลือกตำบล</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="district" class="font_green">รหัสไปรษณีย์</label>
                                        <div class="form-group">
                                            <select name="Postcode_Id" class="form-control postcode">
                                                <option value="">เลือกรหัสไปรษณีย์</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="Bdate_Emp" class="font_green">วันเกิด</label>
                                        <input type="date" class="form-control" name="Bdate_Emp" id="Bdate_Emp" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="Salary_Emp" class="font_green">เงินเดือน</label>
                                        <input type="number" class="form-control" name="Salary_Emp" id="Salary_Emp" placeholder="เงินเดือน" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="image" class="font_green">รูปพนักงาน</label>
                                        <input type="file" class="form-control" name="image" id="image" required>
                                    </div>

                                    <div class="col-md-6">
                                        <table class="table" id="tel">
                                            <tr>
                                                <th class="">เบอร์โทรศัพท์</th>
                                                <th> <button type="button" class="btn btn-success addRowTel"><i class="fas fa-plus"></i></button></th>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="Tel_Emp[]" id="Tel_Emp" placeholder="เบอร์โทรศัพท์" maxlength="10" onkeypress="return onlyNumberKey(event)" required>
                                                    </div>
                                                </th>
                                                <th> <button type="button" class="btn btn-danger remove"><i class="fas fa-minus"></i></button></th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" id="submit" class="btn btn-success"> <i class="fas fa-plus" style="margin-right: 5px;"></i>เพิ่ม</button>
                            <a class="btn btn-danger my-2" href="/Stminishow/showEmployee"> <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>กลับ</a>

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


<!-- <div class="container ">
    <br>
    <h2 class="font_green">เพิ่มข้อมูลพนักงาน</h2>
    <form action="/Stminishow/createEmployee" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <div class="row">

                <div class="col-md-4">
                    <label for="FName_Emp" class="font_green">ชื่อ</label>
                    <input type="text" class="form-control" name="FName_Emp" id="FName_Emp" placeholder="ชื่อ" required>
                </div>
                <div class="col-md-4">
                    <label for="LName_Emp" class="font_green">นามสกุล</label>
                    <input type="text" class="form-control" name="LName_Emp" id="LName_Emp" placeholder="นามสกุล" required >
                </div>
                <div class="col-sm-2">
                    <label for="Position_Id" class="font_green">ตำแหน่ง</label>
                    <select class="form-control" name="Position_Id" required>
                        <option value="">ตำแหน่ง</option>
                        @foreach($positions as $position)
                        <option value="{{$position->Id_Position}}">{{$position->Name_Position}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="Sex_Emp" class="font_green">เพศ</label>
                    <select class="form-control" name="Sex_Emp">
                        <option value="" selected>เลือกเพศ</option>
                        <option value="ชาย">ชาย</option>
                        <option value="หญิง">หญิง</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="Username_Emp" class="font_green">ชื่อผู้ใช้</label>
                    <input type="text" class="form-control" name="Username_Emp" id="Username_Emp" placeholder="ชื่อผู้ใช้" minlength="8"  required>
                  
                </div>
                <d class="col-md-6">
                    <label for="Password_Emp" class="font_green">รหัสผ่าน</label>
                    <input type="password" class="form-control" name="Password_Emp" id="Password_Emp" placeholder="รหัสผ่าน" required>
                
            </div>
        </div>
        <div class="form-group">
            <div class="row">

                <div class="col-md-6">
                    <label for="Address_Emp" class="font_green">ที่อยู่</label>
                    <input type="text" class="form-control" name="Address_Emp" id="Address_Emp" placeholder="ที่อยู่" required>
                </div>
                <div class="col-md-3">
                    <label for="Email_Emp" class="font_green">อีเมล</label>
                    <input type="email" class="form-control" name="Email_Emp" id="Email_Emp" placeholder="อีเมล" required>
                </div>

                <div class="col-md-3">
                    <label for="Idcard_Emp" class="font_green">รหัสบัตรประชาชน</label>
                    
                    <input type="text" class="form-control" name="Idcard_Emp" id="Idcard_Emp" placeholder="รหัสบัตรประชาชน" maxlength="13"  pattern="[0-9]{13}" title="กรุณาให้ให้ครบ 13 ตัว" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  required> 
                    <span class="error"></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                    <label for="province" class="font_green">จังหวัด</label>
                    <div class="form-group">
                        <select name="Province_Id" id="province" class="form-control province" required>
                            <option value="" selected>เลือกจังหวัด</option>
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
                            <option value="">เลือกอำเภอ</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="district" class="font_green">ตำบล</label>
                    <div class="form-group">
                        <select name="Subdistrict_Id" class="form-control district">
                            <option value="">เลือกตำบล</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="district" class="font_green">รหัสไปรษณีย์</label>
                    <div class="form-group">
                        <select name="Postcode_Id" class="form-control postcode">
                            <option value="">เลือกรหัสไปรษณีย์</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="Bdate_Emp" class="font_green">วันเกิด</label>
                    <input type="date" class="form-control" name="Bdate_Emp" id="Bdate_Emp" required>
                </div>

                <div class="col-md-6">
                    <label for="Salary_Emp" class="font_green">เงินเดือน</label>
                    <input type="number" class="form-control" name="Salary_Emp" id="Salary_Emp" placeholder="เงินเดือน" min="0" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderd" id="tel">
                        <tr>
                            <th class="font_green th1">เบอร์โทรศัพท์</th>
                            <th><input type="button" class="btn btn-success addRowTel" value="+"></th>
                        </tr>
                        <tr>
                            <th>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="Tel_Emp[]" id="Tel_Emp" placeholder="เบอร์โทรศัพท์" maxlength="10" onkeypress="return onlyNumberKey(event)" required>
                                </div>
                            </th>
                            <th><input type="button" class="btn btn-danger remove" value="x"></th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <button type="submit" name="submit" id="submit" class="btn btn-success" style="color:black">เพิ่ม</button>

        <a class="btn btn-danger my-2" href="/Stminishow/showEmployee" style="color:black">กลับ</a>
    </form>
</div> -->
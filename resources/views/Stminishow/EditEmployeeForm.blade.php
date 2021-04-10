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
                        <h4>ID : {{$employee->Id_Emp}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="/Stminishow/updateEmployee/{{$employee->Id_Emp}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="FName_Emp" class="font_green">ชื่อ</label>
                                        <input type="text" class="form-control" name="FName_Emp" id="FName_Emp" placeholder="ชื่อ" value="{{$employee->FName_Emp}}" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="LName_Emp" class="font_green">นามสกุล</label>
                                        <input type="text" class="form-control" name="LName_Emp" id="LName_Emp" placeholder="นามสกุล" value="{{$employee->LName_Emp}}" required>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="Position_Id">ตำแหน่ง</label>
                                        <select name="Position_Id" class="form-control">
                                            @foreach($positions as $position)
                                            <option value="{{$position->Id_Position}}" @if($position->Id_Position == $employee->Position_Id)selected
                                                @endif
                                                >{{$position->Name_Position}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="Sex_Emp">เพศ</label>
                                        <select class="form-control" name="Sex_Emp">
                                            @if($employee->Sex_Emp == "ชาย" ){
                                            <option value="ชาย" selected>
                                                {{$employee->Sex_Emp}}
                                            </option>
                                            <option value="หญิง">หญิง</option>
                                            }@else{

                                            <option value="หญิง" selected>
                                                {{$employee->Sex_Emp}}
                                            </option>
                                            <option value="ชาย">ชาย</option>
                                            }
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="Username_Emp" class="font_green">ชื่อผู้ใช้</label>
                                        <input type="text" class="form-control" name="Username_Emp" id="Username_Emp" placeholder="ชื่อผู้ใช้" minlength="8" value="{{$employee->Username_Emp}}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Password_Emp" class="font_green">รหัสผ่าน</label>
                                        <input type="password" class="form-control" name="Password_Emp" id="Password_Emp" placeholder="รหัสผ่าน" value="{{$employee->Password_Emp}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="Address_Emp" class="font_green">ที่อยู่</label>
                                        <input type="text" class="form-control" name="Address_Emp" id="Address_Emp" placeholder="ที่อยู่" value="{{$employee->Address_Emp}}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Email_Emp" class="font_green">อีเมล</label>
                                        <input type="email" class="form-control" name="Email_Emp" id="Email_Emp" placeholder="อีเมล" value="{{$employee->Email_Emp}}" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="Idcard_Emp" class="font_green">รหัสบัตรประชาชน</label>
                                        <input type="text" class="form-control" name="Idcard_Emp" id="Idcard_Emp" placeholder="รหัสบัตรประชาชน" maxlength="13" value="{{$employee->Idcard_Emp}}" pattern="[0-9]{13}" title="กรุณาให้ให้ครบ 13 ตัว" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="province">จังหวัด</label>
                                        <div class="form-group">
                                            <select name="Province_Id" id="Province_Id" class="form-control province">
                                                <option value="{{$employee->Province_Id}}">
                                                    @foreach($list as $row)
                                                    @if($employee->Province_Id == $row->PROVINCE_ID)
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
                                        <label for="amphur">อำเภอ</label>
                                        <div class="form-group">
                                            <select name="District_Id" id="District_Id" class="form-control amphur">
                                                <option value="{{$employee->District_Id}}">
                                                    @foreach($amphur as $row)
                                                    @if($employee->District_Id == $row->AMPHUR_ID)
                                                    {{$row->AMPHUR_NAME}}
                                                    @endif
                                                    @endforeach
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="district">ตำบล</label>
                                        <div class="form-group">
                                            <select name="Subdistrict_Id" class="form-control district">
                                                <option value="{{$employee->Subdistrict_Id}}">
                                                    @foreach($subdistrict as $row)
                                                    @if($employee->Subdistrict_Id == $row->DISTRICT_ID)
                                                    {{$row->DISTRICT_NAME}}
                                                    @endif
                                                    @endforeach
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="district">รหัสไปรษณีย์</label>
                                        <div class="form-group">
                                            <select name="Postcode_Id" class="form-control postcode">
                                                <option value="{{$employee->Postcode_Id}}">
                                                    @foreach($subdistrict as $row)
                                                    @if($employee->Subdistrict_Id == $row->DISTRICT_ID)
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
                                        <label for="Bdate_Emp" class="font_green">วันเกิด</label>
                                        <input type="date" class="form-control" name="Bdate_Emp" id="Bdate_Emp" value="{{$employee->Bdate_Emp}}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="Salary_Emp" class="font_green">เงินเดือน</label>
                                        <input type="number" class="form-control" name="Salary_Emp" id="Salary_Emp" value="{{$employee->Salary_Emp}}" placeholder="เงินเดือน" min="0" required>
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
                                        <table class="table table-borderd" id="tel">
                                            <tr>
                                                <th class="font_green th1">เบอร์โทรศัพท์</th>
                                                <th> <button type="button" class="btn btn-success addRowTel"><i class="fas fa-plus"></i></button></th>
                                            </tr>
                                            @foreach($telemps as $row)
                                            <tr>

                                                <th>


                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="Tel_Emp[]" id="Tel_Emp" value="{{$row->Tel_Emp}}" placeholder="เบอร์โทรศัพท์" maxlength="10" onkeypress="return onlyNumberKey(event)">
                                                    </div>

                                                </th>
                                                <th> <button type="button" class="btn btn-danger remove"><i class="fas fa-minus"></i></button></th>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{asset('storage')}}/Emp_image/{{$employee->Img_Emp}}" alt="" width="150px" height="150px">
                                    </div>
                                </div>
                            </div>


                            <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-pen" style="margin-right: 5px;"></i> แก้ไข</button>
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

    $('.addRowTel').on('click', function() {
        addRowTel();
    });

    function onlyNumberKey(evt) {


        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

    function addRowTel() {
        var addrow = '<tr>' + '<td> <input type="text" class="form-control" name="Tel_Emp[]" id="Tel_Emp" placeholder="เบอร์โทรศัพท์"  maxlength="10" onkeypress="return onlyNumberKey(event)"></td>' +
            ' <th> <button type="button"  class="btn btn-danger remove" ><i class="fas fa-minus" ></i></button></th>' + '</tr>'
        $('#tel').append(addrow);
    }
    $(document).on('click', '.remove', function() {
        $(this).parent().parent().remove();
    });
</script>

@endsection
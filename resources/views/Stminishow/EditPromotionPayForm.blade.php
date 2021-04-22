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
            <h1 class="h1 display">แก้ไขโปรโมชั่นยอดชำระ </h1>
        </header>
        <div class="row">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header  align-items-center">
                        <h4>ID : {{$promotionpays->Id_Promotion}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="/Stminishow/updatePromotionPay/{{$promotionpays->Id_Promotion}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="Name_Promotion" class="font_green">ชื่อโปรโมชั่น</label>
                                        <input type="text" class="form-control" name="Name_Promotion" id="Name_Promotion" placeholder="ชื่อโปรโมชั่น" value="{{$promotionpays->Name_Promotion}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="Brand_Id" class="font_green">ประเภทสินค้า</label>
                                        <select name="Brand_Id" class="form-control">
                                            @foreach($brands as $brand)
                                            <option value="{{$brand->Id_Brand}}" @if($brand->Id_Brand == $promotionpays->Brand_Id)selected
                                                @endif
                                                >{{$brand->Name_Brand}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Salary_Emp" class="font_green">กำหนดยอดชำระ</label>
                                        <input type="text" class=" form-control" name="Payment_Amount" placeholder="กำหนดยอดชำระ" min="0" step="0.01" onkeypress="return onlyNumberKey(event)" value="{{number_format($promotionpays->Payment_Amount,2)}}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="Sdate_Promotion" class="font_green">วันเริ่มต้น</label>
                                        <input type="date" class="form-control" name="Sdate_Promotion" id="Sdate_Promotion" value="{{$promotionpays->Sdate_Promotion}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="Edate_Promotion" class="font_green">วันสิ้นสุด</label>
                                        <input type="date" class="form-control" name="Edate_Promotion" id="Edate_Promotion" value="{{$promotionpays->Edate_Promotion}}">
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderd" id="permium_pro">
                                            <tr>
                                                <th class="">สินค้าของแถม</th>
                                                <th></th>
                                                <th> <button type="button" class="btn btn-success addRowpermium_pro"><i class="fas fa-plus"></i></button></th>
                                            </tr>
                                            @foreach($join1 as $row)
                                            <tr>
                                                <div class="row">
                                                    <th>
                                                        <div class="col-md- form-group">
                                                            <select class="form-control" name="Id_Premium_Pro[]" oninvalid="this.setCustomValidity('กรุณากรอกเลือกสินค้าของแถมเพื่อจัดโปรโมชั่น')" oninput="setCustomValidity('')" required>
                                                                @foreach($PremiumPros as $PremiumPro)
                                                                <option value="{{$PremiumPro->Id_Premium_Pro}}" @if($PremiumPro->Id_Premium_Pro == $row->Id_Premium_Pro)selected
                                                                    @endif
                                                                    >{{$PremiumPro->Name_Premium_Pro}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </th>
                                                    <th>
                                                        <div class="col-sm form-group">
                                                            <input type="text" class="form-control" name="Amount_Premium_Pro[]" value="{{$row->Amount_Premium_Pro}}" id="Amount_Premium_Pro" placeholder="จำนวน"  maxlength="10" onkeypress="return onlyNumberKey(event)">
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
                            <a class="btn btn-danger my-2" href="/Stminishow/ShowPromotionPay"> <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>กลับ</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{csrf_field()}}
<script type="text/javascript">
    $('.addRowpermium_pro').on('click', function() {
        addRowpermium_pro();
    });

    function addRowpermium_pro() {
        var addrow = '<tr>' +
            '     <div class="row">' +
            '<th>' +
            '  <div class="col-md- form-group">' +
            '   <select class="form-control" name="Id_Premium_Pro[]" >' +
            '   <option value="" selected>เลือกสินค้าของแถม  </option>' +
            '@foreach($PremiumPros as $PremiumPro)' +
            '   <option value="{{$PremiumPro->Id_Premium_Pro}}">{{$PremiumPro->Name_Premium_Pro}}</option>' +
            '   @endforeach' +
            '       </select>' +
            '   </div>' +
            ' </th>' +
            ' <th>' +
            ' <div class="col-sm form-group">' +
            '   <input type="text" class="form-control" name="Amount_Premium_Pro[]" id="Amount_Premium_Pro" placeholder="จำนวน" maxlength="10" onkeypress="return onlyNumberKey(event)">' +
            '</div>' +
            '  </th>' +
            
            '        <th> <button type="button" class="btn btn-danger remove"><i class="fas fa-minus"></i></button></th>' +
            '   </div>' +
            '</tr>'
        $('#permium_pro').append(addrow);
    }
    $(document).on('click', '.remove', function() {
        $(this).parent().parent().remove();
    });
    $('#Sdate_Promotion').change(function() {
        var Sdate_Promotion = $(this).val();

        document.getElementById("Edate_Promotion").min = Sdate_Promotion;
    })
</script>
@endsection
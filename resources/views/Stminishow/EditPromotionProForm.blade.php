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
            <h1 class="h1 display">แก้ไขโปรโมชั่นของแถม </h1>
        </header>
        <div class="row">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header  align-items-center">
                        <h4>ID : {{$promotions->Id_Promotion}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="/Stminishow/updatePromotionPro/{{$promotions->Id_Promotion}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="Name_Promotion" class="font_green">ชื่อโปรโมชั่น</label>
                                        <input type="text" class="form-control" name="Name_Promotion" id="Name_Promotion" placeholder="ชื่อโปรโมชั่น" value="{{$promotions->Name_Promotion}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Sdate_Promotion" class="font_green">วันเริ่มต้น</label>
                                        <input type="date" class="form-control" name="Sdate_Promotion" id="Sdate_Promotion" value="{{$promotions->Sdate_Promotion}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Edate_Promotion" class="font_green">วันสิ้นสุด</label>
                                        <input type="date" class="form-control" name="Edate_Promotion" id="Edate_Promotion" value="{{$promotions->Edate_Promotion}}">
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <table class="table table-borderd" id="costs">
                                            <tr>
                                                <th class="font_green th1">สินค้าจัดโปรโมชั่น</th>
                                                <th style="height: 60px;"></th>
                                            </tr>

                                            <tr>
                                                <div class="row">
                                                    <th>
                                                        <div class="col-md form-group">
                                                            <select name="Id_Product" class="form-control">
                                                                @foreach($products as $product)
                                                                <option value="{{$product->Id_Product}}" @if($product->Id_Product == $joinpro)selected
                                                                    @endif
                                                                    >{{$product->Name_Product}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </th>

                                                </div>
                                            </tr>
                                        </table>
                                    </div>
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
                                                            <input type="text" class="form-control" name="Amount_Premium_Pro[]" value="{{$row->Amount_Premium_Pro}}" id="Amount_Premium_Pro" placeholder="จำนวน" maxlength="10" onkeypress="return onlyNumberKey(event)">
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
                            <a class="btn btn-danger my-2" href="/Stminishow/ShowPromotionPro"> <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>กลับ</a>
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
</script>
@endsection
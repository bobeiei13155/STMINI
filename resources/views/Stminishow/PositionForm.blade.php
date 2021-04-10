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
            <h1 class="h1 display">เพิ่มข้อมูลตำแหน่ง</h1>
        </header>
        <div class="row">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header  align-items-center">
                        <h4>ID : {{Session::get('Id_Position')}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="/Stminishow/createPosition" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">

                                    <p id="demo"></p>
                                    <div class="col-md-4">
                                        <!--   -->
                                        <label for="Name_Position" class="font_green">ชื่อตำแหน่ง</label>
                                        <input type="text" class="form-control" name="Name_Position" id="Name_Position" placeholder="ชื่อตำแหน่ง" placeholder="ชื่อตำแหน่ง" pattern="^[ก-๛]+$" title="กรุณากรอกกาษาไทย">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="all" id="inlineCheckbox1" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox1">ทั้งหมด</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="employee" id="inlineCheckbox2" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox2">ข้อมูลพนักงาน</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="position" id="inlineCheckbox3" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox3">ข้อมูลตำแหน่ง</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="product" id="inlineCheckbox4" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox4">ข้อมูลสินค้า</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="partner" id="inlineCheckbox5" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox5">ข้อมูลบริษัทคู่ค้า</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="member" id="inlineCheckbox6" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox6">ข้อมูลลูกค้า</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="promotion" id="inlineCheckbox7" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox7">ข้อมูลโปรโมชั่น</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="premiumpro" id="inlineCheckbox8" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox8">ข้อมูลของแถม</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="offerorder" id="inlineCheckbox9" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox9">เสนอสั่งซื้อสินค้า</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="approveorder" id="inlineCheckbox10" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox10">อนุมัติสั่งซื้อสินค้า</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="order" id="inlineCheckbox11" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox11">สั่งซื้อสินค้า</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="receive" id="inlineCheckbox12" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox12">รับสินค้า</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="sell" id="inlineCheckbox13" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox13">ขายสินค้า</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">

                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="preorder" id="inlineCheckbox14" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox14">ข้อมูลสั่งจองสินค้า</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="receivepreorder" id="inlineCheckbox15" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox15">ข้อมูลรับสินค้าสั่งจอง</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="Claim" id="inlineCheckbox16" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox16">เคลมสินค้า</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="report" id="inlineCheckbox17" value="option1">
                                        <label class="form-check-label font_green" for="inlineCheckbox17">ออกรายงาน</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <button type="submit" name="submit" id="submit" class="btn btn-success"> <i class="fas fa-plus" style="margin-right: 5px;"></i>เพิ่ม</button>
                            <a class="btn btn-danger my-2" href="/Stminishow/showPosition"> <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>กลับ</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{csrf_field()}}
<script type="text/javascript">

</script>
@endsection
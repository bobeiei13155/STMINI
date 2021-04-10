@extends('layouts.stmininav')
@section('body')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<section class="forms">
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="h1 display">แก้ไขประเภทลูกค้า </h1>
        </header>
        <div class="row">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header  align-items-center">
                        <h4>ID : {{$categorymembers->Id_Cmember}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="/Stminishow/updateCategorymember/{{$categorymembers->Id_Cmember}}" method="post">
                        {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="Name_Cmember">ชื่อประเภทลูกค้า</label>
                                        <input type="text" class="form-control" name="Name_Cmember" id="Name_Cmember" placeholder="ชื่อประเภทลูกค้า" value="{{$categorymembers->Name_Cmember}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Discount_Cmember" class="font_green">จำนวนส่วนลดลูกค้า <i style="font-size: 20px;" class="fas fa-percentage"></i> </label>
                                        <input type="number" class="form-control" name="Discount_Cmember" id="Discount_Cmember" placeholder="จำนวนเปอร์เซ็น" min="0" max="100" value="{{$categorymembers->Discount_Cmember}}">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <button type="submit" name="submit" id="submit" class="btn btn-success"> <i class="fas fa-pen" style="margin-right: 5px;"></i>แก้ไข</button>
                        <a class="btn btn-danger my-2" href="/Stminishow/createCategorymember"> <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>กลับ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
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
            <h1 class="h1 display">แก้ไขข้อมูลยี่ห้อสินค้า </h1>
        </header>
        <div class="row">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header  align-items-center">
                        <h4>ID : {{$brands->Id_Brand}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="/Stminishow/updateBrand/{{$brands->Id_Brand}}" method="post">
                        {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="Name_Brand">ชื่อยี่ห้อสินค้า</label>
                                        <input type="text" class="form-control" name="Name_Brand" id="Name_Brand" value="{{$brands->Name_Brand}}">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <button type="submit" name="submit" id="submit" class="btn btn-success"> <i class="fas fa-pen" style="margin-right: 5px;"></i>แก้ไข</button>
                        <a class="btn btn-danger my-2" href="/Stminishow/createBrand"> <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>กลับ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
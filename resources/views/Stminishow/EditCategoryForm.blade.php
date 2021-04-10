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
            <h1 class="h1 display">แก้ไขข้อมูลประเภทสินค้า </h1>
        </header>
        <div class="row">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header  align-items-center">
                        <h4>ID : {{$category->Id_Category}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="/Stminishow/updateCategory/{{$category->Id_Category}}" method="post">
                        {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="Name_Category">ชื่อประเภทสินค้า</label>
                                        <input type="text" class="form-control" name="Name_Category" id="Name_Category" value="{{$category->Name_Category}}">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <button type="submit" name="submit" id="submit" class="btn btn-success"> <i class="fas fa-pen" style="margin-right: 5px;"></i>แก้ไข</button>
                        <a class="btn btn-danger my-2" href="/Stminishow/createCategory"> <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>กลับ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
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
<section class="charts">
    <div class="container-fluid">
        <header>
            <form action="/Stminishow/SearchPTN" method="GET" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <h1 class="h1">ข้อมูลลายสินค้า</h1>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <input type="text" name="searchPTN" class="form-control" style="width: 200px;">
                            <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </header>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- <label for="Name_Category" >ชื่อประเภทสินค้า</label> -->
                    <form action="/Stminishow/createPattern" method="GET" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="col">
                            <div class="input-group">
                                <input type="text" class="form-control" name="Name_Pattern" id="Name_Pattern" placeholder="ชื่อลายสินค้า" style="width: 300px;" required>
                                <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มลายสินค้า</button>
                            </div>
                        </div>
                    </form>
                    <div class="col">
                        <div class="text-right "> รายการข้อมูลทั้งหมด {{$count}} รายการ </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>รหัสลายสินค้า</th>
                            <th>ชื่อลายสินค้า</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patterns as $pattern)
                        <tr>

                            <td scope="row">{{$pattern->Id_Pattern}}</td>
                            <td>{{$pattern->Name_Pattern}}</td>
                            <td>
                                <a href="/Stminishow/editPattern/{{$pattern->Id_Pattern}}" class="btn btn-info" style="border-radius: 5px; width: 90px; "> <i class="fas fa-pen" style="margin-right: 5px;"></i> แก้ไข</a>
                            </td>
                            <td>
                                <a href="/Stminishow/deletePattern/{{$pattern->Id_Pattern}}" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" class="btn btn-danger" style="border-radius: 5px; width: 90px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i> ลบ</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        {{$patterns->links()}}
    </div>
</section>
@endsection
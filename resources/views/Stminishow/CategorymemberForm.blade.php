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
            <form action="/Stminishow/SearchCategorymember" method="GET" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                    <div class="col">
                        <h1 class="h1">ข้อมูลประเภทลูกค้า</h1>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <input type="text" name="SearchCMB" class="form-control" style="width: 200px;">
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
                    <form action="/Stminishow/createCategorymember" method="GET" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="col">
                            <div class="input-group">
                                <input type="text" class="form-control" name="Name_Cmember" id="Name_Cmember" placeholder="ชื่อประเภทลูกค้า" style="width: 300px;" required>
                                <input type="number" class="form-control" name="Discount_Cmember" id="Discount_Cmember" placeholder="จำนวนส่วนลดลูกค้า" min="0" max="100" required>
                                <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มข้อมูลประเภทลูกค้า</button>
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
                    <thead>
                        <tr>
                            <th>รหัสประเภทลูกค้า</th>
                            <th>ชื่อประเภทลูกค้า</th>
                            <th>ส่วนลดลูกค้า</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categorymembers as $categorymember)
                        <tr>

                            <th scope="row">{{$categorymember->Id_Cmember}}</th>
                            <td>{{$categorymember->Name_Cmember}}</td>
                            <td>{{$categorymember->Discount_Cmember}}</td>
                            <td>
                                <a href="/Stminishow/editCategorymember/{{$categorymember->Id_Cmember}}" class="btn btn-info" style="border-radius: 5px; width: 90px; "> <i class="fas fa-pen" style="margin-right: 5px;"></i> แก้ไข</a>
                            </td>
                            <td>
                                <a href="/Stminishow/deleteCategorymember/{{$categorymember->Id_Cmember}}" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" class="btn btn-danger" style="border-radius: 5px; width: 90px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i> ลบ</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{$categorymembers->links()}}
    </div>
</section>
@endsection
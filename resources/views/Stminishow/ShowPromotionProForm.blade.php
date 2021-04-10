@extends('layouts.stmininav')

@section('body')

<section class="charts">
    <div class="container-fluid">
        <header>
            <form action="/Stminishow/SearchPromotionPro" method="GET" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <h1 class="h1">ข้อมูลโปรโมชั่นของแถม</h1>
                    </div>

                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <input type="text" name="searchPOP" class="form-control" style="width: 200px;">
                            <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </header>
        <div class="card">
            <div class="card-header">
                <div class="row ">
                    <div class="col">
                        <a class="btn btn-primary" href="/Stminishow/createPromotionPro"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มโปรโมชั่นของแถม</a>
                    </div>
                    <div class="col">
                        <div class="text-right"> รายการข้อมูลทั้งหมด {{$count}} รายการ </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center ">
                <table class="table table-striped table-hover  ">
                    <thead>
                        <tr>
                            <th>รหัสโปรโมชั่น</th>
                            <th>ชื่อโปรโมชั่น</th>
                            <th>ชื่อสินค้าที่มีของแถม</th>
                            <th>วันเริ่มต้น</th>
                            <th>วันสิ้นสุด</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promotions as $promotion)
                        <tr>

                            <td scope="row">{{$promotion->Id_Promotion}}</td>
                            <td>
                                {{$promotion->Name_Promotion}}
                            </td>
                            <td>
                                @foreach($producttest as $row)
                                @if($promotion->Id_Promotion == $row->Id_Promotion)
                                {{$row->Name_Product}}
                                @endif

                                @endforeach
                            </td>
                            <td>
                                {{$promotion->Sdate_Promotion}}

                            </td>
                            <td>
                                {{$promotion->Edate_Promotion}}
                            </td>
                            <td>
                                <a href="/Stminishow/editPromotionPro/{{$promotion->Id_Promotion}}" class="btn btn-info" style="border-radius: 5px; width: 90px; "> <i class="fas fa-pen" style="margin-right: 5px;"></i> แก้ไข</a>
                            </td>
                            <td>
                                <a href="/Stminishow/editPromotionPro/{{$promotion->Id_Promotion}}" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" class="btn btn-danger" style="border-radius: 5px; width: 90px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i> ลบ</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        {{$promotions->links()}}
    </div>
</section>
@endsection
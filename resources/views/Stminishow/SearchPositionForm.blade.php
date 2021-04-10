@extends('layouts.stmininav')

@section('body')

<section class="charts">
    <div class="container-fluid">
        <header>
            <form action="/Stminishow/SearchPOS" method="GET">
                <div class="row">
                    <div class="col">
                        <h1 class="h1">ค้นหาข้อมูลตำแหน่ง</h1>
                    </div>

                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <input type="text" name="searchPOS" class="form-control" style="width: 200px;">
                            <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </header>
        <div class="card">
            <div class="card-header  align-items-center">
                <div class="row ">
                    <div class="col">
                        <a class="btn btn-primary" href="/Stminishow/createPosition"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มตำแหน่ง</a>
                    </div>
                    <div class="col">
                        <div class="text-right"> รายการข้อมูลทั้งหมด {{$count}} รายการ </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body  text-center ">
                <table class="table  table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>รหัส</th>
                            <th>ตำแหน่ง</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($positions as $position)
                        @if($position->Status == 0 )
                        <tr>

                            <th scope="row">{{$position->Id_Position}}</th>
                            <td>{{$position->Name_Position}}</td>

                            <td>
                                <a href="/Stminishow/editPosition/{{$position->Id_Position}}" class="btn btn-info" style="border-radius: 5px; width: 90px; "> <i class="fas fa-pen" style="margin-right: 5px;"></i> แก้ไข</a>
                            </td>
                            <td>
                                <a href="/Stminishow/deletePosition/{{$position->Id_Position}}" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" class="btn btn-danger" style="border-radius: 5px; width: 90px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i> ลบ</a>
                            </td>
                        </tr>
                        @else
                        <tr style="display: none;">
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{$positions->appends(['searchPOS'=>request()->query('searchPOS')])->links()}}
    </div>
</section>
@endsection
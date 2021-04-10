@extends('layouts.stmininav')

@section('body')

<section class="charts">
    <div class="container-fluid">
        <header>
            <form action="/Stminishow/SearchCategory" method="GET" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <h1 class="h1">ค้นหาข้อมูลประเภทสินค้า</h1>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <input type="text" name="searchCRP" class="form-control" style="width: 200px;">
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
                    <form action="/Stminishow/createCategory" method="GET" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="col">
                            <div class="input-group">
                                <input type="text" class="form-control" name="Name_Category" id="Name_Category" style="width: 300px;" placeholder="ชื่อประเภทสินค้า" required>
                                <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มประเภทสินค้า</button>
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
                            <th>รหัสประเภทสินค้า</th>
                            <th>ชื่อประเภทสินค้า</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        @if($category->Status == 0 )
                        <tr>
                            <td scope="row">{{$category->Id_Category}}</td>
                            <td>{{$category->Name_Category}}</td>
                            <td>
                                <a href="/Stminishow/editCategory/{{$category->Id_Category}}" class="btn btn-info" style="border-radius: 5px; width: 90px; "> <i class="fas fa-pen" style="margin-right: 5px;"></i> แก้ไข</a>
                            </td>
                            <td>
                                <a href="/Stminishow/deleteCategory/{{$category->Id_Category}}" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" class="btn btn-danger" style="border-radius: 5px; width: 90px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i> ลบ</a>
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

        {{$categories->appends(['searchCRP'=>request()->query('searchCRP')])->links()}}
    </div>
</section>
@endsection
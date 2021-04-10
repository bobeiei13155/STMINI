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
            <form action="/Stminishow/SearchCarmodel" method="GET" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <h1 class="h1">ค้นหาข้อมูลรุ่น</h1>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <input type="text" name="searchCMD" class="form-control" style="width: 200px;">
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
                    <form action="/Stminishow/createCarmodel" method="GET" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="col">
                            <div class="input-group">
                                <input type="text" class="form-control" name="Name_Carmodel" id="Name_Carmodel" placeholder="ชื่อรุ่นรถ" style="width: 300px;" required>
                                <select name="Gen_Id" id="Gen" class="form-control" required>
                                    <option value="" selected>เลือกGEN</option>
                                    @foreach($gens as $gen)
                                    <option value="{{$gen->Id_Gen}}">{{$gen->Name_Gen}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-plus" style="margin-right: 5px;"></i> ชื่อรุ่นรถ</button>
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
                            <th>รหัสรุ่นรถ</th>
                            <th>ชื่อรุ่นรถ</th>
                            <th>Genรุ่นรถ</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carmodels as $carmodel)
                        @if($carmodel->Status == 0 )
                        <tr>

                            <td scope="row">{{$carmodel->Id_Carmodel}}</td>
                            <td>{{$carmodel->Name_Carmodel}}</td>
                            <td>
                                @foreach($gens as $gen)
                                @if($carmodel->Gen_Id == $gen->Id_Gen)
                                {{$gen->Name_Gen}}
                                @endif
                                @endforeach
                            </td>
                            <td>
                                <a href="/Stminishow/editCarmodel/{{$carmodel->Id_Carmodel}}" class="btn btn-info" style="border-radius: 5px; width: 90px; "> <i class="fas fa-pen" style="margin-right: 5px;"></i> แก้ไข</a>
                            </td>
                            <td>
                                <a href="/Stminishow/deleteCarmodel/{{$carmodel->Id_Carmodel}}" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" class="btn btn-danger" style="border-radius: 5px; width: 90px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i> ลบ</a>
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
        {{$carmodels->appends(['searchCMD'=>request()->query('searchCMD')])->links()}}

    </div>
</section>
@endsection
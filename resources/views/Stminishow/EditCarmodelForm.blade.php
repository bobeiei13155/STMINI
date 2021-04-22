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
            <h1 class="h1 display">แก้ไขข้อมูลรุ่นรถ </h1>
        </header>
        <div class="row">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header  align-items-center">
                        <h4>ID : {{$carmodel->Id_Carmodel}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="/Stminishow/updateCarmodel/{{$carmodel->Id_Carmodel}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="Name_Carmodel">ชื่อรุ่นรถ</label>
                                        <input type="text" class="form-control" name="Name_Carmodel" id="Name_Carmodel" value="{{$carmodel->Name_Carmodel}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Gen_Id" class="font_green">GEN</label>
                                        <div class="form-group">
                                            <select name="Gen_Id" class="form-control">
                                                @foreach($gens as $gen)
                                                <option value="{{$gen->Id_Gen}}" @if($gen->Id_Gen == $carmodel->Gen_Id)selected
                                                    @endif
                                                    >{{$gen->Name_Gen}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" id="submit" class="btn btn-success"> <i class="fas fa-pen" style="margin-right: 5px;"></i>แก้ไข</button>
                            <a class="btn btn-danger my-2" href="/Stminishow/createCarmodel"> <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>กลับ</a>
                        </form>

                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
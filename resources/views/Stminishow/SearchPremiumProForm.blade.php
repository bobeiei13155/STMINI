@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="/Stminishow/SearchPremiumPro" method="GET" enctype="multipart/form-data">
        <div class="row">
          <div class="col">
            <h1 class="h1">ค้นหาข้อมูลสินค้าของแถม</h1>
          </div>

          <div class="col-sm-2">
            <div class="input-group mb-3">
              <input type="text" name="searchPMP" class="form-control" style="width: 200px;">
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
            <a class="btn btn-primary" href="/Stminishow/createPremiumPro"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มสินค้าของแถม</a>
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
              <th>รหัสของแถม</th>
              <th>รูป</th>
              <th>ชื่อของแถม</th>
              <th>จำนวน</th>
              <th>แก้ไข</th>
              <th>ลบ</th>
            </tr>
          </thead>
          <tbody>
            @foreach($premium_pros as $PremiumPro)
            @if($PremiumPro->Status == 0 )
            <tr>

              <td scope="row">{{$PremiumPro->Id_Premium_Pro}}</td>
              <td>
                <img src="{{asset('storage')}}/PremiumPro_image/{{$PremiumPro->Img_Premium_Pro}}" alt="" width="80px" height="80px">
              </td>
              <td>{{$PremiumPro->Name_Premium_Pro}}</td>
              <td>
                {{$PremiumPro->Amount_Premium_Pro}}
              </td>
              <td>
                <a href="/Stminishow/editPremiumPro/{{$PremiumPro->Id_Premium_Pro}}" class="btn btn-info" style="border-radius: 5px; width: 90px; "> <i class="fas fa-pen" style="margin-right: 5px;"></i> แก้ไข</a>
              </td>
              <td>
                <a href="/Stminishow/deletePremiumPro/{{$PremiumPro->Id_Premium_Pro}}" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" class="btn btn-danger" style="border-radius: 5px; width: 90px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i> ลบ</a>
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
    {{$premium_pros->appends(['searchPMP'=>request()->query('searchPMP')])->links()}}
  </div>
</section>
@endsection
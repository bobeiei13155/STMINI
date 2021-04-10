@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="/Stminishow/SearchPromotionPay" method="GET" enctype="multipart/form-data">
        <div class="row">
          <div class="col">
            <h1 class="h1">ค้นหาข้อมูลโปรโมชั่นยอดชำระ</h1>
          </div>

          <div class="col-sm-2">
            <div class="input-group mb-3">
              <input type="text" name="searchPOM" class="form-control" style="width: 200px;">
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
            <a class="btn btn-primary" href="/Stminishow/createPromotionPay"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มโปรโมชั่นของแถม</a>
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
              <th>ยอดชำระ</th>
              <th>วันเริ่มต้น</th>
              <th>วันสิ้นสุด</th>
              <th>แก้ไข</th>
              <th>ลบ</th>
            </tr>
          </thead>
          <tbody>
            @foreach($promotionpays as $promotionpay)
            @if($promotionpay->Status == 0 )
            <tr>

              <td scope="row">{{$promotionpay->Id_Promotion}}</td>
              <td>
                {{$promotionpay->Name_Promotion}}
              </td>
              <td>

                {{number_format($promotionpay->Payment_Amount,2)}}

              </td>
              <td>
                {{$promotionpay->Sdate_Promotion}}

              </td>
              <td>
                {{$promotionpay->Edate_Promotion}}
              </td>
              <td>
                <a href="/Stminishow/editPromotionPay/{{$promotionpay->Id_Promotion}}" class="btn btn-info" style="border-radius: 5px; width: 90px; "> <i class="fas fa-pen" style="margin-right: 5px;"></i> แก้ไข</a>
              </td>
              <td>
                <a href="/Stminishow/deletePromotionPay/{{$promotionpay->Id_Promotion}}" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" class="btn btn-danger" style="border-radius: 5px; width: 90px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i> ลบ</a>
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

    {{$promotionpays->appends(['searchPOM'=>request()->query('searchPOM')])->links()}}
  </div>
</section>
@endsection
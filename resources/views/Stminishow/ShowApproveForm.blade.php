@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="#" method="GET" enctype="multipart/form-data">
        <div class="row">
          <div class="col">
            <h1 class="h1">อนุมัติสั่งซื้อสินค้า</h1>
          </div>

        
        </div>
      </form>
    </header>
    <div class="card">
      <div class="card-header">
        <div class="row ">
    
          <div class="col-sm-2">
            <div class="input-group mb-3">
              <input type="text" name="searchPOM" class="form-control" style="width: 200px;">
              <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
          </div>
          
          <div class="col">
            <div class="text-right"> รายการข้อมูลทั้งหมด รายการ </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body text-center ">
        <table class="table table-striped table-hover  ">
          <thead>
            <tr>
              <th>รหัสใบเสนอซื้อ</th>
              <th>ชื่อผู้เสนอ</th>
              <th>วันที่เสนอ</th>
              <th>สถานะ</th>
              <th>อนุมัติ</th>     
            </tr>
          </thead>
          <tbody>
            @foreach($offers as $offer)
            <tr>

              <td scope="row">{{$offer->Id_Offer}}</td>
              <td>
                @foreach($employees as $employee)
                @if($offer->Emp_Id == $employee->Id_Emp)
                {{$employee->Fname_Emp}}
                @endif
                @endforeach
              </td>

              <td>
                {{$offer->Offer_date}}
              </td>
              
                @if( $offer->Status_Offer == 0)
                <td>
                ยังไม่พิจารณา
                <td>
                <a href="/Stminishow/ApproveOffer/{{$offer->Id_Offer}}" class="btn btn-info" style="border-radius: 5px; width: 110; "> <i class="fas fa-pen" style="margin-right: 5px;"></i> อนุมัติ</a>
              </td>
                </td>
                @else
                <td>
                พิจารณาแล้ว
                </td>
                <td>
                <input class="btn btn-info" style="border-radius: 5px; width: 110px; " value="อนุมัติแล้ว" disabled>   </input>
              </td>
                @endif

          
           
            </tr>
            @endforeach

          </tbody>
        </table>

      </div>
    </div>

  </div>
</section>
@endsection
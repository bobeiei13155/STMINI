@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="#" method="GET" enctype="multipart/form-data">
        <div class="row">
          <div class="col">
            <h1 class="h1">สั่งซื้อสินค้า</h1>
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
            <a class="btn btn-primary" href="/Order/createOrder"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มใบสั่งซื้อสินค้า</a>
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
              <th>รหัสใบสั่งซื้อ</th>
              <th>ชื่อบริษัท</th>
              <th>ชื่อผู้สั่งซื้อสินค้า</th>
              <th>วันที่สั่งซื้อ</th>
              <th>ยอดรวม</th>
              <th>สถานะ</th>
              <th>พิมพ์ใบสั่งซื้อสินค้า</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
            <tr>

              <td scope="row">{{$order->Id_Order}}</td>
              <td>
                @foreach($partners as $partner)
                @if($order->Id_Partner == $partner->Id_Partner)
                {{$partner->Name_Partner}}
                @endif
                @endforeach
              </td>

              <td>
                {{$order->FName_Emp}}
              </td>
              <td>
                {{$order->Order_Date}}
              </td>
              <td>
              {{number_format($order->Total_Price,2)}}
              </td>
              <td>
                @if($order->Status_Order == 1)
                สั่งซื้อแล้ว
                @endif

              </td>
              <td>
                <a type="button" href="/Order/OrderBill/{{$order->Id_Order}}" class="col-auto btn btn-info " style="border-radius: 5px; width: 140px; " target="_blank"> <i class="fas fa-print" style="margin-right: 5px;"></i> พิมพ์ </a>
              </td>
            </tr>
            @endforeach

          </tbody>
        </table>

      </div>
    </div>
  </div>
</section>
<script>

</script>
@endsection
@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="#" method="GET" enctype="multipart/form-data">
        <div class="row">
          <div class="col">
            <h1 class="h1">รับสินค้าสั่งซื้อ</h1>
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
            <a class="btn btn-primary" href="/Receipt/createReceipt"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มใบรับสินค้า</a>
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
              <th>รหัสใบรับสินค้า</th>
              <th>ชื่อบริษัท</th>
              <th>ชื่อผู้รับสินค้า</th>
              <th>วันที่รับสินค้า</th>
              <th>สถานะ</th>
            </tr>
          </thead>
          <tbody>
            @foreach($receipt_lists as $receipt_list)
            <tr>

              <td scope="row">{{$receipt_list->Id_Order}}</td>
              <td>
                {{$receipt_list->Name_Partner}}
              </td>
              <td>
  
                @foreach($employees as $employee)
                @if($employee->Id_Emp == $receipt_list->Id_Emp)
                {{$employee->FName_Emp}}
                @endif
                @endforeach
              </td>
              <td>
                {{$receipt_list->Receipt_Date}}
              </td>

              <td>
                @if($receipt_list->Status_Order == 0)
                รับสินค้ายังไม่ครบ
                @else
                รับครบแล้ว
                @endif

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
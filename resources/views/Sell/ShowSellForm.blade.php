@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="#" method="GET" enctype="multipart/form-data">
        <div class="row">
          <div class="col">
            <h1 class="h1">ขายสินค้า</h1>
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
            <a class="btn btn-primary" href="/Sell/createSell"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มการขายสินค้า</a>
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
              <th>รหัสใบเสร็จ</th>
              <th>ชื่อพนักขาย</th>
              <th>ชื่อลูกค้า</th>
              <th>วันที่ขายสินค้า</th>
              <th>ยอดรวม</th>
  
            </tr>
          </thead>
          <tbody>
        
          </tbody>
        </table>

      </div>
    </div>
  </div>
</section>
<script>


</script>
@endsection
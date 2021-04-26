@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="#" method="GET" enctype="multipart/form-data">
        <div class="row">
          <div class="col">
            <h1 class="h1">รับสินค้าสั่งจอง</h1>
          </div>

        </div>
      </form>
    </header>
    <div class="card">
      <div class="card-body text-center ">


        <table class="table table-striped table-hover  " id="table_show">
          <thead>
            <tr>
              <th>รหัสใบรับสินค้าสั่งจอง</th>
              <th>ชื่อพนักงาน</th>
              <th>ชื่อลูกค้า</th>
              <th>วันที่สั่งจอง</th>
              <th>วันที่นัดรับสินค้า</th>
              <th>รับสินค้า</th>
            </tr>
          </thead>
          <tbody>
            @foreach($preorders as $preorder)
            <tr>
              <td>{{$preorder->Id_Preorder}}</td>
              <td>{{$preorder->FName_Emp}}</td>
              <td>{{$preorder->FName_Member}}</td>
              <td>{{substr($preorder->Preorder_date,0,10)}}</td>
              <td>{{$preorder->Receive_date}}</td>
              @if($preorder->Status_Preorder  == 1)
              <td>
                  
                <a href="/ReceiptPre/receipt_preorder/{{$preorder->Id_Preorder}}" class="btn btn-info" style="border-radius: 5px; width: 100px; "> <i class="fas fa-pen" style="margin-right: 5px;"></i>รับสินค้า</a>
              </td>
              @else{
                <td>
                  
                รับสินค้าแล้ว
                </td>
              }
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
</section>
<script>
 $(document).ready(function() {
    $('#table_show').DataTable();
  });
</script>
@endsection
@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="#" method="GET" enctype="multipart/form-data">
        <div class="row">
          <div class="col">
            <h1 class="h1">สั่งจองสินค้า</h1>
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
            <a class="btn btn-primary" href="/Preorder/createPreorder"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มการสั่งจองสินค้า</a>
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
              <th>วันที่ขาย</th>
              <th>เวลาที่ขาย</th>
              <th>ยอดรวม</th>
              <th>รายละเอียด</th>
              <th>ยกเลิก</th>
            </tr>
          </thead>
          <tbody>
            @foreach($preorders as $preorder)
            <tr>

              <td scope="row">{{$preorder->Id_Preorder}}</td>
              <td>
                {{$preorder->FName_Emp}}
              </td>
              <td>
                {{$preorder->Name_Member}}
              </td>
              <td>
                <?php
                echo substr($preorder->Preorder_date, 0, 10);
                ?>

              </td>
              <td>
                <?php
                echo substr($preorder->Preorder_date, 10);
                ?>

              </td>
              <td>
                {{number_format($preorder->Total_Price,2)}}
              </td>
              <td>
                <button type="button" data-toggle="modal" data-target="#myModal" class="col-auto btn btn-warning Id_Preorder_Show" style="border-radius: 5px; width: 140px; " id="{{$preorder->Id_Preorder}}"> <i class="fas fa-eye" style="margin-right: 5px;"></i> ดูรายละเอียด </button>
              </td>
              <td>
                <a href="/Preorder/PreorderController/{{$preorder->Id_Preorder}}" class="col-auto btn btn-danger " onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" style="border-radius: 5px; width: 140px; " id="{{$preorder->Id_Preorder}}"> <i class="fas fa-trash-alt" style="margin-right: 5px;"></i> ยกเลิกการขาย </a>
              </td>



            </tr>

            @endforeach
          </tbody>
        </table>

      </div>
    </div>
    <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
      <div role="document" class="modal-dialog modal-xl">
        <div class="modal-content" style="width: auto;">
          <div class="modal-header">
            <h5 id="exampleModalLabel" class="modal-title"><i class="fas fa-star" style="color:#F0B71A; padding-right: 8px; "></i>รายละเอียดการสั่งจอง</h5>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body ">
            <div class="Show_Preorder">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function() {
    $('#table_show').DataTable({
      "lengthMenu": [
        [5, 10, 50, -1],
        [5, 10, 50, "All"]
      ]
    });
  });


  $(document).on("click", ".Id_Preorder_Show", function() {

    var Id_Preorder = $(this).attr("Id");
    var _token = $('input[name="_token"]').val();
    // swal(Id_Sell);
    // var job = $('#' + penis_test + ' td:nth-child(2)').html();
    $.ajax({
      url: "{{route('Preorder.Detail_Preorder')}}",
      method: "POST",
      data: {
        Id_Preorder: Id_Preorder,
        _token: _token
      },
      success: function(result) {
        $('.Show_Preorder').html(result);

      }
    })
  });
</script>
@endsection
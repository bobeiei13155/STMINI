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


        </div>
      </form>
    </header>
    <div class="card">
      <div class="card-header">
        <div class="row ">
          <div class="col">
            <a class="btn btn-primary" href="/Sell/createSell"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มการขายสินค้า</a>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body text-center ">



        <table class="table table-striped table-hover   " id="table_show">
          <thead>
            <tr>
              <th>รหัสใบเสร็จ</th>
              <th>ชื่อพนักขาย</th>
              <th>ชื่อลูกค้า</th>
              <th>วันที่ขาย</th>
              <th>เวลาที่ขาย</th>
              <th>ยอดรวม</th>
              <th>ออกใบเสร็จ</th>
              <th>รายละเอียด</th>
              <th>ยกเลิก</th>
            </tr>
          </thead>
          <tbody>
            @foreach($sells as $sell)
            <tr>

              <td scope="row">{{$sell->Id_Sell}}</td>
              <td>
                {{$sell->FName_Emp}}
              </td>
              <td>
                {{$sell->Name_Member}}
              </td>
              <td>
                <?php
                echo substr($sell->Sell_Date, 0, 10);
                ?>

              </td>
              <td>
                <?php
                echo substr($sell->Sell_Date, 10);
                ?>

              </td>
              <td>
                {{number_format($sell->Payment,2)}}
              </td>
              <td>
                <a type="button" href="/Sell/Bill/{{$sell->Id_Sell}}" class="col-auto btn btn-info Id_Sell_Show_Receipt" style="border-radius: 5px; width: 140px; " id="{{$sell->Id_Sell}}"  target="_blank"> <i class="fas fa-print" style="margin-right: 5px;"></i> พิมพ์ </a>
              </td>
              <td>
                <button type="button" data-toggle="modal" data-target="#myModal" class="col-auto btn btn-warning Id_Sell_Show" style="border-radius: 5px; width: 140px; " id="{{$sell->Id_Sell}}"> <i class="fas fa-eye" style="margin-right: 5px;"></i> ดูรายละเอียด </button>
              </td>
              <td>
              <a href="/Sell/SellController/{{$sell->Id_Sell}}" class="col-auto btn btn-danger " onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" style="border-radius: 5px; width: 140px; " id="{{$sell->Id_Sell}}"> <i class="fas fa-trash-alt" style="margin-right: 5px;"></i> ยกเลิกการขาย </a>
              </td>



            </tr>

            @endforeach
          </tbody>
        </table>

      </div>
      <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-xl">
          <div class="modal-content" style="width: auto;">
            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title"><i class="fas fa-star" style="color:#F0B71A; padding-right: 8px; "></i>รายละเอียดการขาย</h5>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body ">
              <div class="Show_Sell">

              </div>
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


  $(document).on("click", ".Id_Sell_Show", function() {

    var Id_Sell = $(this).attr("Id");
    var _token = $('input[name="_token"]').val();
    // swal(Id_Sell);
    // var job = $('#' + penis_test + ' td:nth-child(2)').html();
    $.ajax({
      url: "{{route('sell.Detail_Sell')}}",
      method: "POST",
      data: {
        Id_Sell: Id_Sell,
        _token: _token
      },
      success: function(result) {
        $('.Show_Sell').html(result);

      }
    })
  });
</script>
@endsection
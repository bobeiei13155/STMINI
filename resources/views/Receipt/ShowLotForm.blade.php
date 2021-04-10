@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="#" method="GET" enctype="multipart/form-data">
        <div class="row">
          <div class="col">

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
            <h1 class="h2">คลังสินค้า</h1>
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
              <th>รหัสล็อต</th>
              <th>วันที่</th>
              <th>เวลา</th>
              <th>ชื่อพนักงานรับ</th>
              <th>รายละเอียด</th>

            </tr>
          </thead>
          <tbody>
            @foreach($lots as $lot)
            <tr>

              <td scope="row">{{$lot->Id_Lot}}</td>
              <td>
                <?php
                echo substr($lot->Receipt_Date, 0, 10);
                ?>

              </td>
              <td>
                <?php
                echo substr($lot->Receipt_Date, 10);
                ?>

              </td>
              <td>

                @foreach($employees as $employee)
                @if($employee->Id_Emp == $lot->Id_Emp)
                {{$employee->FName_Emp}}
                @endif
                @endforeach
              </td>
              <td>
                <button type="button" data-toggle="modal" data-target="#myModal" class="col-auto btn btn-warning buttonID" style="border-radius: 5px; width: 140px; " id="{{$lot->Id_Lot}}"> <i class="fas fa-eye" style="margin-right: 5px;"></i> ดูรายละเอียด </button>
              </td>



            </tr>

            @endforeach
          </tbody>
        </table>

      </div>
    </div>
    <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
      <div role="document" class="modal-dialog">
        <div class="modal-content" style="width: auto;">
          <div class="modal-header">
            <h5 id="exampleModalLabel" class="modal-title">สินค้าภายในล็อต</h5>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <div class="showlot">
            </div>




          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).on("click", ".buttonID", function() {

    var Id_Lot = $(this).attr("Id");
    // swal(button_test);
    var _token = $('input[name="_token"]').val();
    // var job = $('#' + penis_test + ' td:nth-child(2)').html();

    $.ajax({
      url: "{{route('receipt.Detail_Lot')}}",
      method: "POST",
      data: {
        Id_Lot: Id_Lot,
        _token: _token
      },
      success: function(showlot) {
        // $('.showcost').append(showcost);
        $('.showlot').html(showlot);
      }
    })


  });
</script>
@endsection
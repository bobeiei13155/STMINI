@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="#" method="GET" enctype="multipart/form-data">
        <div class="row">
          <div class="col">
            <h1 class="h1">ข้อมูลใบเสนอสั่งซื้อสินค้า</h1>
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
            <a class="btn btn-primary" href="/Stminishow/createOffer"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มใบเสนอสั่งซื้อ</a>
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
              <th>ดูรายละเอียด</th>
      
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
              <td>
                @if( $offer->Status_Offer == 0)
                ยังไม่พิจารณา
                @else
                พิจารณาแล้ว
                @endif

              </td>
              <td>
                <button type="button" data-toggle="modal" data-target="#myModal" class="col-auto btn btn-warning buttonID" style="border-radius: 5px; width: 140px; " id="{{$offer->Id_Offer}}"> <i class="fas fa-eye" style="margin-right: 5px;"></i> ดูรายละเอียด </button>
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
            <h5 id="exampleModalLabel" class="modal-title">เลือกสินค้าเสนอสั่งซื้อ</h5>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <div class="showcost">
            </div>




          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).on("click", ".buttonID", function() {

    var Id_Offer = $(this).attr("Id");
    // swal(button_test);
    var _token = $('input[name="_token"]').val();
    // var job = $('#' + penis_test + ' td:nth-child(2)').html();

    $.ajax({
      url: "{{route('offer.Detail_Offer')}}",
      method: "POST",
      data: {
        Id_Offer: Id_Offer,
        _token: _token
      },
      success: function(showcost) {
        // $('.showcost').append(showcost);
        $('.showcost').html(showcost);
      }
    })


  });
</script>
@endsection
@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="#" method="GET" enctype="multipart/form-data">
        <div class="row">
          <div class="col">
            <h1 class="h1">เคลมสินค้า</h1>
          </div>


        </div>
      </form>
    </header>
    <div class="card">
      <div class="card-header">
        <div class="row ">
          <div class="col">
            <a class="btn btn-primary" href="/Claim/createClaim"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มการเคลมสินค้า</a>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body text-center ">



        <table class="table table-striped table-hover" id="table_show">
          <thead>
            <tr>
              <th>รหัสใบเคลม</th>
              <th>ชื่อพนักขาย</th>
              <th>ชื่อลูกค้า</th>
              <th>วันที่เคลมสินค้า</th>
              <th>วันที่รับสินค้าเคลม</th>
              <th>รายละเอียด</th>
              <th>ยกเลิก</th>
            </tr>
          </thead>
          <tbody>
           
          </tbody>
        </table>

      </div>
      <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-xl">
          <div class="modal-content" style="width: auto;">
            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title"><i class="fas fa-star" style="color:#F0B71A; padding-right: 8px; "></i>รายละเอียดใบเสร็จ</h5>
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


  $(document).on("click", ".", function() {

    var Id_Sell = $(this).attr("Id");
    
    var _token = $('input[name="_token"]').val();
    // swal(Id_Sell);
    // var job = $('#' + penis_test + ' td:nth-child(2)').html();
    // $.ajax({
    //   url: "{{route('sell.Detail_Sell')}}",
    //   method: "POST",
    //   data: {
    //     Id_Sell: Id_Sell,
    //     _token: _token
    //   },
    //   success: function(result) {
    //     $('.Show_Sell').html(result);

    //   }
    // })
  });


</script>
@endsection
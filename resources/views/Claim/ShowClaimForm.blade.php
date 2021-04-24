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
              <th>ชื่อพนักงาน</th>
              <th>ชื่อลูกค้า</th>
              <th>วันที่เคลมสินค้า</th>
              <th>รายละเอียด</th>

            </tr>
          </thead>
          <tbody>
            @foreach($claims as $claim)
            <tr>
              <td>{{$claim->Id_Claim}}</td>
              <td>{{$claim->FName_Emp}}</td>
              <td>{{$claim->FName_Member}}</td>
              <td>{{$claim->Claim_Date}}</td>
              <td> <button type="button" data-toggle="modal" data-target="#myModal" class="col-auto btn btn-warning Id_Claim_Show" style="border-radius: 5px; width: 140px; " id="{{$claim->Id_Claim}}"> <i class="fas fa-eye" style="margin-right: 5px;"></i> ดูรายละเอียด </button></td>


            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
      <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-xl">
          <div class="modal-content" style="width: auto;">
            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title"><i class="fas fa-star" style="color:#F0B71A; padding-right: 8px; "></i>รายละเอียดการเคลม</h5>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body ">
              <div class="Show_Claim">

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


  $(document).on("click", ".Id_Claim_Show", function() {

    var Id_Claim = $(this).attr("Id");
    var _token = $('input[name="_token"]').val();
    // swal(Id_Sell);
    // var job = $('#' + penis_test + ' td:nth-child(2)').html();
    $.ajax({
      url: "{{route('Claim.Detail_Claim')}}",
      method: "POST",
      data: {
        Id_Claim: Id_Claim,
        _token: _token
      },
      success: function(result) {
        $('.Show_Claim').html(result);

      }
    })
  });


  
</script>
@endsection
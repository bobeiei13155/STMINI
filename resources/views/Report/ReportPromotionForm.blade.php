@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>

      <div class="row">
        <div class="col">
          <h1 class="h1">สรุปยอดการใช้โปรโมชั่น</h1>
        </div>

      </div>

    </header>
    <div class="card">
      <div class="card-header">
        <form action="/Report/Select_Promotion" method="POST" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="row ">
            <div class="col-sm-2">
              <label for="Position_Id" class="font_green">ช่วงเวลาเริ่มต้น</label>
              <input type="date" name="Sdate" class="form-control" Id="Sdate" value="" required>
            </div>
            <div class="col-sm-2">
              <label for="Position_Id" class="font_green">ช่วงเวลาสิ้นสุด</label>
              <input type="date" name="Edate" class="form-control" Id="Edate" value="" required>
            </div>
            <div class="col-sm-1">
              <label for="Position_Id" class="font_green" style="padding-top:16px;"></label>
              <button type="submit" id="chk" class="form-control btn" style="background-color: #42A667;color:#FFF; border-radius:5px"><i class="fas fa-search"></i></button>
            </div>
          </div>

          <div class="col-sm-5 text-center">

          </div>
      </div>


      </form>

      <div class="row">
        <div class="col">

          <div class="card">
            <center>
              <div id="piechart" style="width: 900px; height: 500px; ">

              </div>
            </center>
            <div class="card-body text-center  Show_Report_Sell">
              <table class="table table-striped table-hover" id="table_show_payment">
                <thead>
                  <tr>
                    <th>ชื่อโปรโมชั่น</th>
                    <th>ยอดการใช้โปรโมชั่น</th>
                    <th>รายละเอียดของแถม</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($reportpromotions as $reportpromotion)
                  <tr>
                    <td>{{$reportpromotion->Name_Promotion}}</td>
                    <td>{{$reportpromotion->Count_Payment}}</td>
                    <td><button type="button" class="btn btn-warning ID_Promotion_Payment " id="{{$reportpromotion->Id_Promotion}} " value="{{$reportpromotion->Id_Promotion}} " style="border-radius: 5px;  " data-toggle="modal" data-target="#myModal_Promotion_De_2"> <i class="fas fa-eye"></i></button></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

            </div>

          </div>
        </div>
        <div id="myModal_Promotion_De_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog modal-lg">
                <div class="modal-content" style="width: auto;">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title"><i class="fas fa-star" style="color:#6586FA; padding-right: 8px; "></i>รายละเอียดโปรโมชั่นยอดชำระ</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="show_payment_promotion">

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col">
          <div class="card">
            <center>
              <div id="piechart_promotion" style="width: 900px; height: 500px; ">

              </div>
            </center>
            <div class="card-body text-center  Show_Report_Sell">
              <table class="table table-striped table-hover" id="table_show_product">
                <thead>
                  <tr>
                    <th>ชื่อโปรโมชั่น</th>
                    <th>ยอดการใช้โปรโมชั่น</th>
                    <th>รายละเอียดของแถม</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($reportpromotion_products as $reportpromotion_product)
                  <tr>
                    <td>{{$reportpromotion_product->Name_Promotion}}</td>
                    <td>{{$reportpromotion_product->Count_Promotion}}</td>
                    <td><button type="button" class="btn btn-warning ID_Promotion_Product " id="{{$reportpromotion_product->Id_Promotion}} " value="{{$reportpromotion_product->Id_Promotion}} " style="border-radius: 5px;  " data-toggle="modal" data-target="#myModal_Promotion_De_1"> <i class="fas fa-eye"></i></button></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

            </div>

          </div>
        </div>
      </div>
      <div id="myModal_Promotion_De_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
          <div class="modal-content" style="width: auto;">
            <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title"><i class="fas fa-star" style="color:#F0B71A; padding-right: 8px; "></i>รายละเอียดโปรโมชั่นของแถม</h5>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

              <div class="show_product_promotion">

              </div>

            </div>
          </div>
        </div>
      </div>



    </div>




</section>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
  $(document).ready(function() {
    $('#table_show_payment').DataTable();
  });
  $(document).ready(function() {
    $('#table_show_product').DataTable();
  });
  $(document).on("click", "#chk", function() {


    if (Edate == "" && Sdate == "") {

      swal('กรุณากรอกช่วงเวลา');
    }
    // var Edate = $(this).val();



  });



  $('#Sdate').change(function() {
    var Sdate = $(this).val();

    document.getElementById("Edate").min = Sdate;

  })

  google.charts.load('current', {
    'packages': ['corechart']
  });
  google.charts.setOnLoadCallback(drawChart);


  function drawChart() {
    // Define the chart to be drawn.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Element');
    data.addColumn('number', 'โปรโมชั่นยอดชำระ');
    data.addRows([
    @foreach($reportpromotions as $reportpromotion)[
        '{{ $reportpromotion->Name_Promotion }}', {{$reportpromotion->Count_Payment}}
      ],
      @endforeach
    ]);
    // data.addRows([
    //     ['Nitrogen', 0.10],
    //     ['Oxygen', 0.10],
    //     ['Other', 0.10]
    // ]);

    var option = {
      title: 'ยอดการใช้โปรโมชั่นยอดชำระ',

    }
    // Instantiate and draw the chart.
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, option);
  }



  google.charts.load('current', {
    'packages': ['corechart']
  });
  google.charts.setOnLoadCallback(drawChart_Products);


  function drawChart_Products() {
    // Define the chart to be drawn.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Element');
    data.addColumn('number', 'โปรโมชั่นของแถม');
    data.addRows([
 
      @foreach($reportpromotion_products as $reportpromotion_product)[
        '{{ $reportpromotion_product->Name_Promotion }}', {{$reportpromotion_product->Count_Promotion}}
      ],
      @endforeach
    ]);
  
    // data.addRows([
    //     ['Nitrogen', 0.10],
    //     ['Oxygen', 0.10],
    //     ['Other', 0.10]
    // ]);

    var option = {
      title: 'ยอดการใช้โปรโมชั่นของแถม',

    }
    // Instantiate and draw the chart.
    var chart = new google.visualization.PieChart(document.getElementById('piechart_promotion'));
    chart.draw(data, option);
  }




  $(document).on("click", ".ID_Promotion_Product", function() {

    var Id_Promotion = $(this).attr("Id");
    // swal(button_test);
    var _token = $('input[name="_token"]').val();
    // var job = $('#' + penis_test + ' td:nth-child(2)').html();

    $.ajax({
      url: "{{route('Report.Detail_Promotion_Products')}}",
      method: "POST",
      data: {
        Id_Promotion: Id_Promotion,
        _token: _token
      },
      success: function(show_product_promotion) {
        // $('.showcost').append(showcost);
        $('.show_product_promotion').html(show_product_promotion);
      }
    })


  });



  $(document).on("click", ".ID_Promotion_Payment", function() {

    var Id_Promotion = $(this).attr("Id");
    // swal(Id_Promotion);
    var _token = $('input[name= "_token"]').val();
    // var job = $('#' + penis_test + ' td:nth-child(2)').html();

    $.ajax({
      url: "{{route('Report.Detail_Promotion_Payments')}}",
      method: "POST",
      data: {
        Id_Promotion: Id_Promotion,
        _token: _token
      },
      success: function(show_payment_promotion) {
        // $('.showcost').append(showcost);
        $('.show_payment_promotion').html(show_payment_promotion);
      }
    })


  });
</script>
@endsection
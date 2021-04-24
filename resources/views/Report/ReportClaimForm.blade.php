@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>

      <div class="row">
        <div class="col">
          <h1 class="h1">สรุปยอดการเคลมสินค้า</h1>
        </div>

      </div>

    </header>
    <div class="card">
      <div class="card-header">
        <form action="/Report/Select_Claim" method="POST" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="row ">
            <div class="col-sm-2">
              <label for="Position_Id" class="font_green">ประเภทสินค้า</label>
              <select class="form-control" name="cate" id="cate"  selected>
                <option value="">เลือกประเภทสินค้า </option>
                @foreach($cates as $cate)
                <option value="{{$cate->Id_Category}}">{{$cate->Name_Category}}</option>
                @endforeach
              </select>
            </div>
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
      <center>
        <div id="piechart" style="width: 900px; height: 500px; ">

        </div>
      </center>

      </form>
      <div class="card">
        <div class="card-body text-center  Show_Report_Sell">
          <table class="table table-striped table-hover" id="table_show">
            <thead>
              <tr>
                <th>ชื่อสินค้า</th>
                <th>จำนวนการเคลม</th>
                <th>ประเภทสินค้า</th>
              </tr>
            </thead>
            <tbody>
              @foreach($reportclaims as $reportclaim)
              <tr>
                <td>{{$reportclaim->Name_Product}}</td>
                <td>{{$reportclaim->Amount_Claim}}</td>
                <td>{{$reportclaim->Name_Category}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>

        </div>

      </div>
    </div>




</section>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
  $(document).ready(function() {
    $('#table_show').DataTable();
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
    data.addColumn('number', 'Percentage');
    data.addRows([
      @foreach($reportclaims as $row)[
        '{{ $row->Name_Product }}', {{$row->Amount_Claim}}
      ],
      @endforeach
    ]);
    // data.addRows([
    //     ['Nitrogen', 0.10],
    //     ['Oxygen', 0.10],
    //     ['Other', 0.10]
    // ]);

    var option = {
      title: 'ยอดสินค้าเคลม',
  
    }
    // Instantiate and draw the chart.
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, option);
  }
</script>
@endsection
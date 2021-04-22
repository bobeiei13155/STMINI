@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="#" method="GET" enctype="multipart/form-data">
        <div class="row">
          <div class="col">
            <h1 class="h1">ปริมาณยอดขายประจำปี</h1>
          </div>

        </div>
      </form>
    </header>
    <div class="card">
      <div class="card-header">
        <div class="row ">
          <div class="col-sm-2">
            <label for="Position_Id" class="font_green">ปี</label>
            <select class="form-control" name="Year" id="Year" required>
              <option value="2021">2021</option>
              <option value="2020">2020</option>
              <option value="2019">2019</option>
              <option value="2018">2018</option>
              <option value="2017">2017</option>
              <option value="2016">2016</option>
              <option value="2015">2015</option>
              <option value="2014">2014</option>
              <option value="2013">2013</option>
              <option value="2012">2012</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body text-center ">



        <table class="table table-striped table-hover" id="table_show">
          <thead>
            <tr>
              <th>ชื่อสินค้า</th>
              <th>Jan</th>
              <th>Feb</th>
              <th>Mar</th>
              <th>Apr</th>
              <th>May</th>
              <th>Jun</th>
              <th>Jul</th>
              <th>Aug</th>
              <th>Sep</th>
              <th>Oct</th>
              <th>Nov</th>
              <th>Dec</th>
            </tr>
          </thead>
          <tbody class="Show_Costtap">
            @foreach($costtap as $row)
            <tr>
              <td>{{$row->Name_Product}}</td>
              <td>{{number_format($row->Jan,2)}}</td>
              <td>{{number_format($row->Feb,2)}}</td>
              <td>{{number_format($row->Mar,2)}}</td>
              <td>{{number_format($row->Apr,2)}}</td>
              <td>{{number_format($row->May,2)}}</td>
              <td>{{number_format($row->Jun,2)}}</td>
              <td>{{number_format($row->Jul,2)}}</td>
              <td>{{number_format($row->Aug,2)}}</td>
              <td>{{number_format($row->Sep,2)}}</td>
              <td>{{number_format($row->Oct,2)}}</td>
              <td>{{number_format($row->Nov,2)}}</td>
              <td>{{number_format($row->Dec,2)}}</td>
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
  $('#Year').change(function() {
    if ($(this).val() != '') {
      var year = $(this).val();
      var _token = $('input[name="_token"]').val();
      // swal(year);

      $.ajax({
        url: "{{route('report.select_corttap')}}",
        method: "POST",
        data: {
          year: year,
          _token: _token
        },
        success: function(result) {
          $('.Show_Costtap').html(result);
          // alert(result);


        }
      })
    }
  });
</script>
@endsection
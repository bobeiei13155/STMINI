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
              <th>Sum</th>
            </tr>

          </thead>
          <tbody class="Show_Costtap">
           {{$sum1 = 0}}
           {{$sum2 = 0}}
           {{$sum3 = 0}}
           {{$sum4 = 0}}
           {{$sum5 = 0}}
           {{$sum6 = 0}}
           {{$sum7 = 0}}
           {{$sum8 = 0}}
           {{$sum9 = 0}}
           {{$sum10 = 0}}
           {{$sum11 = 0}}
           {{$sum12 = 0}}
           {{$Sum_total = 0}}
            @foreach($costtap as $row)
            <tr>
              <td>{{$row->Name_Product}}</td>
              <td class="Jan_s" >{{number_format($row->Jan,2)}}</td>
              <td> {{number_format($row->Feb,2)}}</td>
              <td class="Mar_s"> {{number_format($row->Mar,2)}} </td>
              <td class="Apr_s">{{number_format($row->Apr,2)}}</td>
              <td class="May_s">{{number_format($row->May,2)}}</td>
              <td class="Jun_s" >{{number_format($row->Jun,2)}}</td>
              <td class="Jul_s">{{number_format($row->Jul,2)}}</td>
              <td  class="Aug_s">{{number_format($row->Aug,2)}}</td>
              <td class="Sep_s">{{number_format($row->Sep,2)}}</td>
              <td class="Oct_s">{{number_format($row->Oct,2)}}</td>
              <td class="Nov_s">{{number_format($row->Nov,2)}}</td>
              <td class="Dec_s">{{number_format($row->Dec,2)}}
              </td>
              <td class="Sum1_s">{{number_format($row->Sum1,2)}}</td>
            </tr>
           {{$sum1 +=  $row->Jan}} 
           {{$sum2 +=  $row->Feb}} 
           {{$sum3 +=  $row->Mar}} 
           {{$sum4 +=  $row->Apr}} 
           {{$sum5 +=  $row->May}} 
           {{$sum6 +=  $row->Jun}} 
           {{$sum7 +=  $row->Jul}} 
           {{$sum8 +=  $row->Aug}} 
           {{$sum9 +=  $row->Sep}} 
           {{$sum10 +=  $row->Oct}} 
           {{$sum11 +=  $row->Nov}} 
           {{$sum12 +=  $row->Dec}} 
           {{$Sum_total +=  $row->Sum1}} 
            @endforeach

          </tbody>
          <tr>
            <th>ราคารวม</th>
            <th> <input id="Jan" value="{{$sum1}}" readonly> </input></th>
            <th><input id="Feb" value="{{$sum2}}" readonly> </input></th>
            <th><input id="Mar" value="{{$sum3}}" readonly> </input></th>
            <th><input id="Apr" value="{{$sum4}}" readonly> </input></th>
            <th><input id="May" value="{{$sum5}}" readonly> </input></th>
            <th><input id="Jun" value="{{$sum6}}" readonly> </input></th>
            <th><input id="Jul" value="{{$sum7}}" readonly> </input></th>
            <th><input id="Aug" value="{{$sum8}}" readonly> </input></th>
            <th><input id="Sep" value="{{$sum9}}" readonly> </input></th>
            <th><input id="Oct" value="{{$sum10}}" readonly> </input></th>
            <th><input id="Nov" value="{{$sum11}}" readonly> </input></th>
            <th><input id="Dec" value="{{$sum12}}" readonly> </input></th>
            <th><input id="Sum" value="{{$Sum_total}}" readonly> </input></th>
          </tr>
        </table>

      </div>

    </div>
  </div>
</section>
<script>


  $(document).ready(function() {
    Jan_sum = 0
    $('.Jan_s').each(function() {
      Jan_sum += parseFloat($(this).val());

      // alert(Jan_sum);
    });



    document.getElementById('Jan').value = Jan_sum;



    Feb_sum = 0
    $('.Feb_s').each(function() {
      Feb_sum += parseFloat($(this).val());
      // alert($(this).val());
    });
    document.getElementById('Feb').value = Feb_sum


    Mar_sum = 0
    $('.Mar_s').each(function() {
      Mar_sum += parseFloat($(this).val());
      // alert($(this).val());
    });
    document.getElementById('Mar').value = Mar_s


    Apr_sum = 0
    $('.Apr_s').each(function() {
      Apr_sum += parseFloat($(this).val());
      // alert($(this).val());
    });
    document.getElementById('Apr').value = Apr_sum


    May_sum = 0
    $('.May_s').each(function() {
      May_sum += parseFloat($(this).val());
      // alert($(this).val());
    });
    document.getElementById('May').value = May_sum



    Jun_sum = 0
    $('.Jun_s').each(function() {
      Jun_sum += parseFloat($(this).val());
      // alert($(this).val());
    });
    document.getElementById('Jun').value = Jun_sum


    Jul_sum = 0
    $('.Jul_s').each(function() {
      Jul_sum += parseFloat($(this).val());
      // alert($(this).val());
    });
    document.getElementById('Jul').value = Jul_sum



    Aug_sum = 0
    $('.Aug_s').each(function() {
      Aug_sum += parseFloat($(this).val());
      // alert($(this).val());
    });
    document.getElementById('Aug').value = Aug_sum


    Sep_sum = 0
    $('.Sep_s').each(function() {
      Sep_sum += parseFloat($(this).val());
      // alert($(this).val());
    });
    document.getElementById('Sep').value = Sep_sum



    Oct_sum = 0
    $('.Oct_s').each(function() {
      Oct_sum += parseFloat($(this).val());
      // alert($(this).val());
    });
    document.getElementById('Oct').value = Oct_sum


    Nov_sum = 0
    $('.Nov_s').each(function() {
      Nov_sum += parseFloat($(this).val());
      // alert($(this).val());
    });
    document.getElementById('Nov').value = Nov_sum

    Dec_sum = 0
    $('.Dec_s').each(function() {
      Dec_sum += parseFloat($(this).val());
      // alert($(this).val());
    });
    document.getElementById('Dec').value = Dec_sum


  });







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
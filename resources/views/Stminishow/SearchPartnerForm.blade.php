@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="/Stminishow/SearchPartner" method="GET">
        <div class="row">
          <div class="col">
            <h1 class="h1">ค้นหาข้อมูลบริษัทคู่ค้า</h1>
          </div>

          <div class="col-sm-2">
            <div class="input-group mb-3">
              <input type="text" name="searchPTN" class="form-control" style="width: 200px;">
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
            <a class="btn btn-primary" href="/Stminishow/createPartner"><i class="fas fa-plus" style="margin-right: 5px;"></i>เพิ่มบริษัทคู่ค้า</a>
          </div>
          <div class="col">
            <div class="text-right"> รายการข้อมูลทั้งหมด {{$count}} รายการ </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body text-center">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>รหัสบริษัทคู่ค้า</th>
              <th>ชื่อบริษัทคู่ค้า</th>
              <th>เบอร์โทรศัพท์</th>
              <th>แก้ไข</th>
              <th>ลบ</th>
            </tr>
          </thead>
          <tbody>
            @foreach($partners as $partner)
            @if($partner->Status == 0 )
            <tr>

              <td scope="row">{{$partner->Id_Partner}}</td>
              <td>{{$partner->Name_Partner}}</td>
              <td>
                {{$partner->Tel_PTN}}
              </td>
              <td>
                <a href="/Stminishow/editPartner/{{$partner->Id_Partner}}" class="btn btn-info" style="border-radius: 5px; width: 90px; "> <i class="fas fa-pen" style="margin-right: 5px;"></i> แก้ไข</a>
              </td>
              <td>
                <a href="/Stminishow/deletePartner/{{$partner->Id_Partner}}" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" class="btn btn-danger" style="border-radius: 5px; width: 90px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i> ลบ</a>
              </td>
            </tr>
            @else
            <tr style="display: none;">
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
    {{$partners->appends(['searchPTN'=>request()->query('searchPTN')])->links()}}
  </div>
</section>
@endsection
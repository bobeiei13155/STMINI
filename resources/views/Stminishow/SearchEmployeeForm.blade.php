@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="/Stminishow/SearchEmployee" method="GET">
        <div class="row">
          <div class="col">
            <h1 class="h1">ข้อมูลค้นหาพนักงาน</h1>
          </div>

          <div class="col-sm-2">
            <div class="input-group mb-3">
              <input type="text" name="searchEmp" class="form-control" style="width: 200px;">
              <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </div>
      </form>
    </header>
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header  align-items-center">
            <div class="row ">
              <div class="col">
                <a class="btn btn-primary" href="/Stminishow/createEmployee"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มพนักงาน</a>
              </div>
              <div class="col">
                <div class="text-right"> รายการข้อมูลทั้งหมด {{$count}} รายการ </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body text-center">
            <table class="table  table-hover">
              <thead class="thead-dark">
                <tr>
                  <th>รหัสพนักงาน</th>
                  <th>รูป</th>
                  <th>ชื่อ</th>
                  <th>นามสกุล</th>
                  <th>อีเมล</th>
                  <th>เงินเดือน</th>
                  <th>ตำแหน่ง</th>
                  <th>แก้ไข</th>
                  <th>ลบ</th>
                </tr>
              </thead>
              <tbody>
                @foreach($employees as $employee)
                @if($employee->Status == 0 )
                <tr>
                  <td scope="row">{{$employee->Id_Emp}}</td>
                  <td>
                    <img src="{{asset('storage')}}/Emp_image/{{$employee->Img_Emp}}" alt="" width="80px" height="80px">
                  </td>
                  <td>{{$employee->FName_Emp}}</td>
                  <td>{{$employee->LName_Emp}}</td>
                  <td>{{$employee->Email_Emp}}</td>
                  <td>{{number_format($employee->Salary_Emp,2)}}</td>
                  <td>
                    @foreach($positions as $position)
                    @if($employee->Position_Id == $position->Id_Position)
                    {{$position->Name_Position}}
                    @endif
                    @endforeach
                  </td>

                  <td>
                    <a href="/Stminishow/editEmployee/{{$employee->Id_Emp}}" class="btn btn-info" style="border-radius: 5px; width: 90px; "> <i class="fas fa-pen" style="margin-right: 5px;"></i> แก้ไข</a>
                  </td>
                  <td>
                    <a href="/Stminishow/deleteEmployee/{{$employee->Id_Emp}}" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" class="btn btn-danger" style="border-radius: 5px; width: 90px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i> ลบ</a>
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
      </div>
    </div>
  </div>

  {{$employees->appends(['searchEmp'=>request()->query('searchEmp')])->links()}}

</section>
@endsection
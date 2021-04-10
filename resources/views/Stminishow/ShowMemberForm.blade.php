@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="/Stminishow/SearchMember" method="GET">
        <div class="row">
          <div class="col">
            <h1 class="h1">ข้อมูลลูกค้า</h1>
          </div>

          <div class="col-sm-2">
            <div class="input-group mb-3">
              <input type="text" name="searchMEM" class="form-control" style="width: 200px;">
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
            <a class="btn btn-primary" href="/Stminishow/createMember"><i class="fas fa-plus" style="margin-right: 5px;"></i>เพิ่มลูกค้า</a>
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
              <th>รหัสลูกค้า</th>
              <th>ชื่อลูกค้า</th>
              <th>นามสกุลลูกค้า</th>
              <th>เบอร์โทรลูกค้า</th>
              <th>ประเภทลูกค้า</th>
              <th>แก้ไข</th>
              <th>ลบ</th>
            </tr>
          </thead>
          <tbody>
            @foreach($members as $member)
            <tr>

              <td scope="row">{{$member->Id_Member}}</td>
              <td>{{$member->FName_Member}}</td>
              <td>{{$member->LName_Member}}</td>
              <td>
                @foreach($telmems as $telmem)
                @if($telmem->Id_Member == $member->Id_Member)
                {{$telmem->Tel_MEM}}
                @break
                @endif
                @endforeach
              </td>
              <td>
                @foreach($categorymembers as $categorymember)
                @if($categorymember->Id_Cmember == $member->Cmember_Id)
                {{$categorymember->Name_Cmember}}
                @endif
                @endforeach
              </td>
              <td>
                <a href="/Stminishow/editMember/{{$member->Id_Member}}" class="btn btn-info" style="border-radius: 5px; width: 90px; "> <i class="fas fa-pen" style="margin-right: 5px;"></i> แก้ไข</a>
              </td>
              <td>
                <a href="/Stminishow/deleteMember/{{$member->Id_Member}}" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" class="btn btn-danger" style="border-radius: 5px; width: 90px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i> ลบ</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    {{$members->links()}}
  </div>
</section>
@endsection
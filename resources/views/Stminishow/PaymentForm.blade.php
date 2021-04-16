@extends('layouts.stmininav')

@section('body')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<section class="charts">
    <div class="container-fluid">
        <header>
            <form action="#" method="GET" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                    <div class="col">
                        <h1 class="h1">ข้อมูลประเภทลูกค้า</h1>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group mb-3">
                            <input type="text" name="#" class="form-control" style="width: 200px;">
                            <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </header>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- <label for="Name_Category" >ชื่อประเภทสินค้า</label> -->
                    <form action="/Stminishow/createPayment" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="col">
                            <div class="input-group">
                                <input type="text" class="form-control" name="Name_Payment" id="Name_Payment" placeholder="ชื่อประเภทการชำระ" style="width: 300px;" required>
                                <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มข้อมูลประเภทการชำระ</button>
                            </div>
                        </div>
                    </form>
                    <div class="col">
                        <div class="text-right "> รายการข้อมูลทั้งหมด รายการ </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>รหัสประเภทการชำระ</th>
                            <th>ชื่อประเภทการชำระ</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($show_payments as $show_payment)
                        <tr>
                            <td>{{$show_payment->Id_Payment}}</td>
                            <td>{{$show_payment->Name_Payment}}</td>
                            <td>
                                <a href="/Stminishow/editPayment/{{$show_payment->Id_Payment}}" class="btn btn-info" style="border-radius: 5px; width: 90px; "> <i class="fas fa-pen" style="margin-right: 5px;"></i> แก้ไข</a>
                            </td>
                            <td>
                                <a href="/Stminishow/deletePayment/{{$show_payment->Id_Payment}}" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" class="btn btn-danger" style="border-radius: 5px; width: 90px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i> ลบ</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>
@endsection
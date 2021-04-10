@extends('layouts.stmininav')
@section('body')
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

<section class="forms">
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="h1 display">แก้ไขสินค้าของแถม </h1>
        </header>
        <div class="row">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header  align-items-center">
                        <h4>ID : {{$premium_pros->Id_Premium_Pro}}</h4>
                    </div>
                    <div class="card-body">
                        <form action="/Stminishow/updatePremiumPro/{{$premium_pros->Id_Premium_Pro}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="Name" class="font_green">ชื่อของแถม</label>
                                        <input type="text" class="form-control" name="Name" id="Name" value="{{$premium_pros->Name_Premium_Pro}}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="Amount" class="font_green">จำนวนสินค้าของแถม</label>
                                        <input type="text" class="form-control" name="Amount" id="Amount" value="{{$premium_pros->Amount_Premium_Pro}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{asset('storage')}}/PremiumPro_image/{{$premium_pros->Img_Premium_Pro}}" alt="" width="150px" height="150px">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="image" class="font_green">รูปสินค้าของแถม</label>
                                     
                                        <input type="file" class="form-control" name="image" id="image">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <button type="submit" name="submit" id="submit" class="btn btn-success"> <i class="fas fa-pen" style="margin-right: 5px;"></i>แก้ไข</button>
                            <a class="btn btn-danger my-2" href="/Stminishow/ShowPremiumPro"> <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>กลับ</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{csrf_field()}}
<script type="text/javascript">

</script>
@endsection
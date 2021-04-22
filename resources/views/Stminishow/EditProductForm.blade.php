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
            <h1 class="h1 display">แก้ไขสินค้า </h1>
        </header>
        <div class="row">
            <div class="col-lg-10">
                <form action="/Stminishow/updateProduct/{{$products->Id_Product}}" method="post" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header  align-items-center">
                            <div class="row">
                                <div class="col">
                                    <h4>ID : {{$products->Id_Product}}</h4>
                                </div>
                                <div class="col-md-3 text-right">
                                    <select class="form-control" name="Statuspre">
                                        @if($products->Statuspre == "0" ){
                                        <option value="0" selected>
                                            สั่งจองสินค้าได้
                                        </option>
                                        <option value="1">ไม่สามารถสั่งจองสินค้าได้</option>
                                        }@else{

                                        <option value="1" selected>
                                            ไม่สามารถสั่งจองสินค้าได้
                                        </option>
                                        <option value="0">สั่งจองสินค้าได้</option>
                                        }
                                        @endif


                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            {{csrf_field()}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="Name_Product" class="font_green">ชื่อสินค้า</label>
                                        <input type="text" class="form-control" name="Name_Product" id="Name_Product" value="{{$products->Name_Product}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="Category_Id" class="font_green">ประเภทสินค้า</label>
                                        <select name="Category_Id" class="form-control">
                                            @foreach($categories as $category)
                                            <option value="{{$category->Id_Category}}" @if($category->Id_Category == $products->Category_Id)selected
                                                @endif
                                                >{{$category->Name_Category}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="Brand_Id" class="font_green">ยี่ห้อ</label>
                                        <select class="form-control" name="Brand_Id">
                                            @foreach($brands as $brand)
                                            <option value="{{$brand->Id_Brand}}" @if($brand->Id_Brand == $products->Brand_Id)selected
                                                @endif
                                                > {{$brand->Name_Brand}}
                                            </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="Gen_Id" class="font_green">รุ่นที่ใส่ได้</label>
                                        <select class="form-control" name="Gen_Id">
                                            <option value="{{$products->Gen_Id}}">
                                                @foreach($gens as $gen)
                                                @if($products->Gen_Id == $gen->Id_Gen)
                                                {{$gen->Name_Gen}}
                                                @endif
                                                @endforeach
                                            </option>
                                            @foreach($gens as $gen)
                                            <option value="{{$gen->Id_Gen}}">{{$gen->Name_Gen}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="Color_Id" class="font_green">สี</label>
                                        <select class="form-control" name="Color_Id">
                                            <option value="{{$products->Color_Id}}">
                                                @foreach($colors as $color)
                                                @if($products->Color_Id == $color->Id_Color)
                                                {{$color->Name_Color}}
                                                @endif
                                                @endforeach
                                            </option>
                                            @foreach($colors as $color)
                                            <option value="{{$color->Id_Color}}">{{$color->Name_Color}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="Pattern_Id" class="font_green">ลาย</label>
                                        <select class="form-control" name="Pattern_Id">
                                            <option value="{{$products->Pattern_Id}}">
                                                @foreach($patterns as $pattern)
                                                @if($products->Pattern_Id == $pattern->Id_Pattern)
                                                {{$pattern->Name_Pattern}}
                                                @endif
                                                @endforeach
                                            </option>
                                            @foreach($patterns as $pattern)
                                            <option value="{{$pattern->Id_Pattern}}">{{$pattern->Name_Pattern}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="Insurance" class="font_green">ระยะเวลาประกัน</label>
                                        <select class="form-control" name="Insurance">
                                            <option value="{{$products->Insurance}}" selected>{{$products->Insurance}}</option>
                                            <option value="365">1ปี</option>
                                            <option value="730">2ปี</option>
                                            <option value="0">ไม่มีประกัน</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="Purchase" class="font_green">จุดสั่งซื้อ</label>
                                        <input type="number" class="form-control" name="Purchase" id="Purchase" placeholder="จุดสั่งซื้อ" min="0" value="{{$products->Purchase}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="Price" class="font_green">ราคาขาย</label>
                                        <input type="number" class="form-control" name="Price" id="Price" placeholder="ราคาขาย" min="0" value="{{$products->Price}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="image_product" class="font_green">รูปสินค้า</label>
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                    <br>
                                    <div class="row ">
                                        <div class="col-md-4 ">
                                            <img src="{{asset('storage')}}/Products_image/{{$products->Img_Product}}" alt="" width="150px" height="150px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="Detail" class="font_green">รายละเอียด</label>
                                    <textarea class="form-control" id="Detail" rows="4" name="Detail" value="{{$products->Detail}}">{{$products->Detail}} </textarea>
                                </div>
                            </div>
                            <br>
                            <button type="submit" name="submit" id="submit" class="btn btn-success"> <i class="fas fa-pen" style="margin-right: 5px;"></i>แก้ไข</button>
                            <a class="btn btn-danger my-2" href="/Stminishow/ShowProduct"> <i class="fas fa-arrow-left" style="margin-right: 5px;"></i>กลับ</a>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

{{csrf_field()}}
<script type="text/javascript">

</script>
@endsection
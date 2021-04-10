@extends('layouts.stmininav')

@section('body')

<section class="charts">
  <div class="container-fluid">
    <header>
      <form action="/Stminishow/SearchPRO" method="GET" enctype="multipart/form-data">
        <div class="row">
          <div class="col">
            <h1 class="h1">ค้นหาข้อมูลสินค้า</h1>
          </div>

          <div class="col-sm-2">
            <div class="input-group mb-3">
              <input type="text" name="searchPRO" class="form-control" style="width: 200px;">
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
            <a class="btn btn-primary" href="/Stminishow/createProduct"><i class="fas fa-plus" style="margin-right: 5px;"></i> เพิ่มสินค้า</a>
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
        <thead class="thead-dark">
            <tr>
              <th>รหัสสินค้า</th>
              <th>รูป</th>
              <th>ชื่อสินค้า</th>
              <th>ประเภทสินค้า</th>
              <th>ยี่ห้อสินค้า</th>
              <th>Gen</th>
              <th>ราคาขาย</th>
              <th>แก้ไข</th>
              <th>ลบ</th>
            </tr>
          </thead>
          <tbody>
            @foreach($products as $product)
            @if($product->Status == 0 )
            <tr>

              <td scope="row">{{$product->Id_Product}}</td>
              <td>
                <img src="{{asset('storage')}}/Products_image/{{$product->Img_Product}}" alt="" width="80px" height="80px">
              </td>
              <td>{{$product->Name_Product}}</td>
              <td>
                @foreach($categories as $category)
                @if($product->Category_Id == $category->Id_Category)
                {{$category->Name_Category}}
                @endif
                @endforeach
              </td>
              <td>
                @foreach($brands as $brand)
                @if($product->Brand_Id == $brand->Id_Brand)
                {{$brand->Name_Brand}}
                @endif
                @endforeach
              </td>
              <td>
                @foreach($gens as $gen)
                @if($product->Gen_Id == $gen->Id_Gen)
                {{$gen->Name_Gen}}
                @endif
                @endforeach
              </td>
              <td>
                {{number_format($product->Price,2)}}
              </td>

              <td>
                <a href="/Stminishow/editProduct/{{$product->Id_Product}}" class="btn btn-info" style="border-radius: 5px; width: 90px; "> <i class="fas fa-pen" style="margin-right: 5px;"></i> แก้ไข</a>
              </td>
              <td>
                <a href="/Stminishow/deleteProduct/{{$product->Id_Product}}" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" class="btn btn-danger" style="border-radius: 5px; width: 90px; "> <i class="fas fa-trash" style="margin-right: 5px;"></i> ลบ</a>
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


    {{$products->appends(['searchPRO'=>request()->query('searchPRO')])->links()}}
  </div>
</section>
@endsection
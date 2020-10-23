@extends('layouts.admin')

@section('body')

<div class="container-fluid mb-3">
    <div class= "row">
        <div class="col-2 pl-0">
            <a name="" id="" class="btn btn-success" href="/product/create" role="button">Tạo Sản Phẩm</a>
        </div>
    </div>
</div>
<table class="table">
  <thead class="bg-primary text-light border rounded">
    <tr>
      <th scope="col">STT</th>
      <th scope="col">Mã SP</th>
      <th scope="col">Tên Sản Phẩm</th>
      <th scope="col">Giá</th>
      <th scope="col">Khuyến Mãi</th>
      <th scope="col">Từ Ngày</th>
      
      <th scope="col">Đến Ngày</th>
      <th scope="col">Mô Tả</th>
      <th scope="col">Danh Mục</th>
      <th scope="col">Thao Tác</th>
    </tr>
  </thead>
  <tbody>
      <?php $stt = 1; ?>
  @foreach ( $products as $product )
      <tr>
        <th scrope="row"><?php echo $stt; $stt++ ;?></th>
        <td>{{$product->product_id}}</td>
        <td>{{$product->name}}</td>
        <td>{{$product->price}}</td>
        {{-- <td>{{$product->type}}</td> --}}
                @if ($product->type == 1)
            <td>Có</td>
        @else 
            <td>Không</td>
        @endif
        <td>{{$product->from_date}}</td>
        <td>{{$product->end_date}}</td>
        <td>{{$product->description}}</td>
        <td>DANH MUC</td>
        <td>
            <a name="" id="" class="btn btn-primary mb-1" href="#" role="button">Chi Tiết</a>
            <a name="" id="" class="btn btn-warning mb-1" href="#" role="button">Cập Nhật</a>
        </td>
      </tr>
  @endforeach
  </tbody>
</table>


<script src=""/>
@endsection
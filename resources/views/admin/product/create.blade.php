@extends('layouts.admin')
@section('style')
<link href="{{asset('css/styles.css')}}" rel="stylesheet">
@endsection
@section('js')
<script src="{{asset('js/create-product.js')}}"></script>
@endsection
@section('body')

<div class="container">
    <form class="form-horizontal col-10" role="form" enctype="multipart/form-data>
        <h2 class="text-center">Tạo Sản Phẩm</h2>
        <!-- name -->
        <div class="form-group">
            <label for="name" class="control-label text-primary font-weight-bold">Tên Sản Phẩm</label>
            <div class="">
                <input type="text" id="name" placeholder="Tên Sản Phẩm" class="form-control" autofocus>
            </div>
        </div>
        <!-- Description -->
        <div class="form-group">
            <label for="description" class=" control-label text-primary font-weight-bold">Mô Tả Sản Phẩm</label>
            <div class="">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="1"></textarea>
            </div>
        </div>
        <!-- price and campaign -->
        <div class="row">
            <!-- price -->
            <div class="form-group col-3">
                <label for="price" class=" control-label text-primary font-weight-bold">Giá Bán</label>
                <div class="">
                    <input type="number" id="name" placeholder="VND" class="form-control" autofocus min="1" step="0.01">
                </div>
            </div>
            <!-- campaign -->
            <div class="form-group col-3">
                <label for="campaign" class="control-label text-primary font-weight-bold">Khuyến Mãi</label>
                <div class="">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="campaign" id="inlineRadio1" value="1">
                        <label class="form-check-label" for="inlineRadio1">Có</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="campaign" id="inlineRadio2" value="2">
                        <label class="form-check-label" for="inlineRadio2">Không</label>
                    </div>
                </div>
            </div>
            <!-- from_date -->
            <div class="form-group col-3">
                <label for="from_date" class=" control-label text-primary font-weight-bold">Bắt Đầu Ngày</label>
                <div class="">
                    <input class="form-control" type="date" id="example-date-input">
                </div>
            </div>
            <!-- end_date -->
            <div class="form-group col-3">
                <label for="end_date" class=" control-label text-primary font-weight-bold">Kết Thúc Ngày</label>
                <div class="">
                    <input class="form-control" type="date" id="example-date-input">
                </div>
            </div>
        </div>
        <!-- from_date & end_date -->
        <div class="row">

        </div>

        <!-- category -->
        <div class="form-group">
            <label for="category" class=" control-label text-primary font-weight-bold">Category</label>
            <div class="col-sm-12">
                @foreach ($categories as $category)
                <div class="custom-control custom-checkbox checkbox-lg col-sm-4 mb-2">
                    <input type="checkbox" class="custom-control-input" id="checkbox-{{$category->category_id}}"
                        value="{{$category->category_id}}">
                    <label class="custom-control-label"
                        for="checkbox-{{$category->category_id}}">{{$category->category_name}}</label>
                </div>
                @endforeach
            </div>
        </div>
        <!-- Images -->
        <div class="form-group">
            <label for="category" class=" control-label text-primary font-weight-bold">Tải Lên Ảnh Sản Phẩm</label>
            <div class="col-md-4 col-md-offset-4">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <input id="logo-id" name="files[]" type="file" class="attachment_upload">
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-img-preview border-danger" id="img_preview">
                <img class="thumbnail img-preview" src="" title="Preview Logo">
                <img class="thumbnail img-preview" src="" title="Preview Logo">
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary btn-block">Register</button>
    </form> <!-- /form -->
</div> <!-- ./container -->
@endsection
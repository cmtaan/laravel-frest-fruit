@extends('layouts.admin')
@section('body')
<div class="main-card mb-3 card">
    <div class="card-body">
        <h5 class="card-title">Bootstrap 4 Form Validation</h5>
        
        <form class="needs-validation" id="form_" action="{{url('/category')}}/{{$cate->category_id}}" onsubmit=" return edit_category()" novalidate method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-9">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                            <input type="hidden" name="category_id" id="category_id" value="{{$cate->category_id}}">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">Name Category</label>
                                <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Name category" value="{{$cate->category_name}}" required>
                                <div id="category_name_error" style="color:red">
                                    
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom02">Description</label>
                                <input type="text" class="form-control" name="description" id="description" placeholder="description" value="{{$cate->description}}" required>
                                <div id="description_error" style="color:red">
                                    
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">Image</label>
                                <div class="custom-file">
                                    <input type="file"  name="image" id="image" class="custom-file-input" id="validatedCustomFile" required>
                                    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                    <div id="image_error" style="color:red"></div>
                                </div>
                            </div>
                        </div>
<<<<<<< HEAD
                    
                        <button class="btn btn-primary"  type="submit">Edit category</button>
=======
                        <a href="{{ URL::previous() }}" class="btn btn-warning" style="color:white">Quay lại</a>

                        <button class="btn btn-primary"  type="submit">Submit form</button>
>>>>>>> 0e6d3fa... update route,controller

                    </div>
                    <div class="col-md-3">
                            <div class="custom-control custom-radio">
                                <input  checked type="radio" id="uncate" name="category_parent_id" value="0" class="custom-control-input">
                                <label class="custom-control-label" for="uncate">Không có category cha</label>
                            </div>
                            @foreach($list_cate as $key => $value)
                            @php
                                if($value->category_id==$cate->category_parent_id)  $symple="checked";
                                else $symple='';
                                
                            @endphp
                                @if($value->category_id!==$cate->category_id) 
                                    <div class="custom-control custom-radio" style="margin-left:{{$value->level}}0px">
                                        <input value="{{$value->category_id}}" {{$symple}} type="radio" id="{{$value->category_name}}{{$value->category_id}}" name="category_parent_id" class="custom-control-input">
                                        <label class="custom-control-label" for="{{$value->category_name}}{{$value->category_id}}">{{$value->category_name}}</label>
                                    </div>
                                @endif
                            @endforeach
                    </div>
            </div>
        </form>
            
        <script>
            
            function edit_category(){
                
                var id=$('#category_id').val();
                var category_name=$('#category_name').val();
                var description=$('#description').val();
                var image=$('#image').prop('files')[0];
                
                console.log(image);
                console.log(category_name);
                var _token=$("input[name='_token']").val();
                var category_parent_id=$('input[name="category_parent_id"]');
                $.each(category_parent_id,function(index,item){
                    if(item.checked==true){
                        category_parent_id=$(this).val();
                    }
                })
                
                var formdata= new FormData(  );
                formdata.append('category_id',id);
                formdata.append('_token',_token);
        
                formdata.append('category_name',category_name);
                formdata.append('description',description);
                formdata.append('category_parent_id',category_parent_id);
                
                if(image!==undefined)formdata.append('image',image);
                var success=false;
                $.ajax({
                    
                    type: "POST",    
                    url: "{{url('api/editcategory/validation')}}",
                    data: formdata,
                    contentType:false,
                    processData:false,
                    async:false,
                    dataType: "json",
                    success: function (response) {
                        if(!$.isEmptyObject(response.error)){
                            console.log(response);
                            if(response.error.category_name!==undefined && response.error.category_name.length>0){
                                $('#category_name_error').html('');
                                $('#category_name_error').append('<div>'+response.error.category_name[0]+'</div>')
                            }else{
                                $('#category_name_error').html('');
                            }
                            if(response.error.description!==undefined && response.error.description.length>0){
                                $('#description_error').html('');
                                $('#description_error').append('<div>'+response.error.description[0]+'</div>')
                            }else{
                                $('#description_error').html('');
                            }
                            if(response.error.image!==undefined && response.error.image.length>0){
                                $('#image_error').html('');
                                $('#image_error').append('<div>'+response.error.image[0]+'</div>')
                            }else{
                                $('#image_error').html('');
                            }
                           
                        }else{
                            console.log('oke r ');
                            success=true;
                            
                        }
                    }
                });
               console.log(success);
               return success;
            }
            // // Example starter JavaScript for disabling form submissions if there are invalid fields
            // (function() {
            //     'use strict';
            //     window.addEventListener('load', function() {
            //         // Fetch all the forms we want to apply custom Bootstrap validation styles to
            //         var forms = document.getElementsByClassName('needs-validation');
            //         // Loop over them and prevent submission
            //         var validation = Array.prototype.filter.call(forms, function(form) {
            //             form.addEventListener('submit', function(event) {
            //                 if (form.checkValidity() === false) {
            //                     event.preventDefault();
            //                     event.stopPropagation();
            //                 }
            //                 form.classList.add('was-validated');
            //             }, false);
            //         });
            //     }, false);
            // })();

        </script>
    </div>
</div>
@endsection
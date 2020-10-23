@extends('layouts.admin')
@section('body')
<div class="main-card mb-3 card">
    <div class="card-body">
        <h5 class="card-title">Add user</h5>
        
        <form class="needs-validation" id="form_" action="{{url('user/')}}/{{$user->user_id}}" onsubmit=" return add_user()" novalidate method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">User Name</label>
                                <input type="text" class="form-control" name="user_name" id="user_name" placeholder="User name" value="{{$user->user_name}}" required>
                                <div id="user_name_error" class="p_error" style="color:red">
                                    
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom02">Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{$user->email}}" required>
                                <div id="email_error" class="p_error" style="color:red">
                                    
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">Image</label>
                                <div class="custom-file">
                                    <input type="file"  name="image" id="image" class="custom-file-input" id="validatedCustomFile" required>
                                    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                    <div id="image_error" class="p_error" style="color:red"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">First name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First name" value="{{$user->first_name}}" required>
                                <div id="first_name_error" class="p_error" style="color:red">
                                    
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom02">Last name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last name" value="{{$user->last_name}}" required>
                                <div id="last_name_error" class="p_error" style="color:red">
                                    
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom02">Mobile</label>
                                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile" value="{{$user->mobile}}" required>
                                <div id="mobile_error" class="p_error" style="color:red">
                                    
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01" >Province</label>
                                <select class="select2 form-control"  name="province" id="province">
                                    <option value="0">Chọn Thành phố, tỉnh</option>
                                    @foreach($province as $key =>$value)

                                        <option value="{{$value->id}}"
                                            @if($value->id==$user->province) selected @endif
                                        >
                                            {{$value->_name}}
                                        </option>
                                    @endforeach
                                    
                                </select>
                                <div id="province_error"  class="p_error" style="color:red">
                                    
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01" >District</label>
                                <select class="select2 form-control" id="district" name="district">
                                    <option value="0">Chọn quận huyện..</option>
                                    @foreach($district as $key =>$value)
                                    <option value="{{$value->id}}"
                                        @if($value->id==$user->district) selected @endif
                                    >
                                        {{$value->_name}}
                                    </option>
                                    @endforeach
                                    <script>
                                        $('#province').change(function(){
                                            var _token=$('input[name="_token"]').val()
                                            $.ajax({
                                                type: "post",
                                                url: "{{url('api/province')}}/"+$(this).val(),
                                                data: {_token:_token},
                                                dataType: "json",
                                                success: function (response) {
                                                    console.log(response);
                                                    $('#district').html('');
                                                    $('#ward').html('<option value="0">Chọn khu vực</option>');
                                                        $('#district').append('<option value="0">Chọn quận huyện..</option>')
                                                            $.each(response.district,function(indexs,items){
                                                                var optDistrict='<option value="'+items.id+'">'+items._name+'</option>';
                                                                $('#district').append(optDistrict)
                                                                console.log('appended');
                                                            })
                                                }
                                            });
                                        })
                                    </script>
                                </select>
                                <div id="district_error" class="p_error" style="color:red">
                                    
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">Ward</label>
                                <select class="select2 form-control" id="ward" name="ward">
                                    <option value="0">Chọn khu vực</option>
                                    @foreach($ward as $key =>$value)
                                     <option value="{{$value->id}}"
                                     @if($value->id==$user->ward) selected @endif
                                     >{{$value->_name}}</option>
                                    @endforeach
                                        <script>
                                            $('#district').change(function(){
                                                var _token=$('input[name="_token"]').val();
                                                $.ajax({
                                                    type: "post",
                                                    url: "{{url('api/district')}}/"+$(this).val(),
                                                    data: {_token:_token},
                                                    dataType: "json",
                                                    success: function (response) {
                                                        $('#ward').html('');
                                                        $('#ward').append('<option value="">Chọn khu vực</option>')
                                                        $.each(response.ward,function(index,item){
                                                            $('#ward').append('<option value="'+item.id+'">'+item._name+'</option>')
                                                        })
                                                    }
                                                });
                                            })
                                        </script>
                                </select>
                                <div id="ward_error"  class="p_error" style="color:red">
                                    
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">Address</label>
                                <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{$user->address}}" required>
                                <div id="address_error"  class="p_error" style="color:red">
                                    
                                </div>
                            </div>
                            
                            
                        </div>

                        <a href="{{ URL::previous() }}" class="btn btn-warning" style="color:white">Quay lại</a>

                        <button class="btn btn-primary"  type="submit">Edit user</button>
        </form>

        <script>
            function add_user(){
                var user_name=$('#user_name').val();
                var email=$('#email').val();
                var first_name=$('#first_name').val();
                var last_name=$('#last_name').val();
                var mobile=$('#mobile').val();
                var province=$('#province').val();
                var district=$('#district').val();
                var ward=$('#ward').val();
                var address=$('#address').val();
                var image=$('#image').prop('files')[0];
                var _token=$("input[name='_token']").val();
                var address=$('#address').val();
                // console.log('province '+province);
                // console.log('district '+district);
                // console.log('ward '+ward);
                // console.log('user_name '+user_name);
                // console.log('email '+email);
                // console.log('first_name '+first_name);
                // console.log('last_name '+last_name);
                // console.log('mobile '+mobile);
                // console.log(image);
                var formdata= new FormData(  );
                formdata.append('_token',_token);
                formdata.append('province',province);
                formdata.append('district',district);
                formdata.append('ward',ward);
                formdata.append('user_name',user_name);
                formdata.append('email',email);
                formdata.append('first_name',first_name);
                formdata.append('last_name',last_name);
                formdata.append('mobile',mobile);
                
                if(image!==undefined) formdata.append('image',image);
                formdata.append('address',address)
                var success=false;
                $.ajax({
                    type: "POST",
                    url: "{{url('api/user/validateedit')}}",
                    data: formdata,
                    contentType: false, 
                    processData: false,
                    async:false,
                    dataType: "json",
                    success: function (response) {
                        
                        if(!$.isEmptyObject(response.error)){
                            console.log(response.error);
                            $('.p_error').html('');
                            $.each(response.error,function(index,item){
                                $('#'+index+'_error').html(item)
                            })
                        }else{
                            // console.log(JSON.stringify(response.success));
                            // window.location.href="{{url('admin/cate')}}"
                            success=true
                        }
                    }
                });
                return success;
            }
            

        </script>
    </div>
</div>
@endsection
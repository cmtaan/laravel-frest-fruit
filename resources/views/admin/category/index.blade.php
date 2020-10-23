@extends('layouts.admin')
    @section('body')
        <div class="card">
            <div class="card-header">
                <div class="card-title">Danh sách danh mục</div>
            </div>
           
            <div class="card-body">
                <div class="table-responsive-lg">
                    <table class="table table-striped table-inverse table-responsive" style="display:table">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Name category</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list_cate as $key => $value)
                            <tr>
                                <td scope="row">{{$value->category_name}}</td>
                                <td>{{$value->description}}</td>
                                <td> <img src="{{asset('images')}}/{{$value->path}}" style="width:50px;height:50px;" alt=""> </td>
                                <td>{{($value->status==1)?'Active':'No active'}}</td>
                                <td >
                                    <a class="btn btn-success" href="{{url('')}}/category/{{$value->category_id}}/edit">Edit</a>
                                    <form class="p_delete" style="display:inline-block" onsubmit="return delete_cate({{$value->category_id}})"  action="{{url('/category')}}/{{$value->category_id}}" method="post">
                                        @csrf 
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-danger" value="Xóa">
                                       
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <script>
        function delete_cate(id){
            console.log(id);
            var _token=$('input[name="_token"]').val();
            var success=false;
            $.ajax({
                type: "DELETE",
                url: "{{url('/category')}}/"+id,
                data: {_token:_token},
                dataType: "json",
                success: function (response) {
                    if(!$.isEmptyObject(response.error)){
                        console.log(response.error);
                    }else{
                        alert('delete success')
                        window.location.href="{{url('category')}}";
                    }
                }
            });
            return false;
        }
    </script>
@endsection

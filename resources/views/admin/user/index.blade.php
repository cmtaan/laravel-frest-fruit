@extends('layouts.admin')
@section('body')
<div class="card">
    <div class="card-body">
        <h3 class="card-title">Danh sách người dùng</h3>
        <div class="table-responsive-lg">
            <table class="table table-striped table-inverse table-responsive" style="display:table">
                <thead class="thead-inverse">
                    <tr>
                        <th>User name</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Province</th>
                        <th>District</th>
                        <th>Ward</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list_user as $key => $value)
                    <tr> 
                            <td scope="row">{{$value->user_name}}</td>
                            <td>{{$value->last_name}}&nbsp;{{$value->first_name}}</td>
                            <td> {{$value->email}} </td>
                            <td> {{$value->province}} </td>
                            <td> {{$value->district}} </td>
                            <td> {{$value->ward}} </td>
                            <td>{{($value->active==1)?'Active':'No active'}}</td>
                            <td >
                                <a class="btn btn-success" href="{{url('/user')}}/{{$value->user_id}}/edit">Edit</a>
                                <form  style="display:inline-block" action="{{url('/user')}}/{{$value->user_id}}" method="post">
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

@endsection
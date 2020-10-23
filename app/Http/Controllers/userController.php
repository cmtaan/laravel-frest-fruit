<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=DB::select('select tbl_user.user_id,tbl_user.user_name,tbl_user.email,tbl_user.first_name,tbl_user.last_name,tbl_user.active,tbl_province._name as province,tbl_district._name as district, tbl_ward._name as ward from tbl_user 
        INNER JOIN tbl_province on tbl_user.province=tbl_province.id 
        INNER JOIN tbl_district on tbl_user.district=tbl_district.id 
        INNER JOIN tbl_ward on tbl_user.ward= tbl_ward.id'
        );

        return view('admin.user.index',['list_user'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $province=DB::table('tbl_province')->get();
        return view('admin.user.add',['province'=>$province]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated=Validator::make($request->all(),
            [
                'user_name'=>'bail|required|regex:/^[A-z0-9]*$/',
                'first_name'=>'required',
                'last_name'=>'required',
                'mobile'=>'required|bail|regex:/^0[0-9]{9,10}$/',
                'email'=>'required|email|bail',
                'district'=>'required|not_in:0',
                'province'=>'required|not_in:0',
                'ward'=>'required|not_in:0',
                'image'=>'required|image',
                'address'=>'required'
            ],
            [
                'required'=>':attribute không được rỗng',
                'regex'=>':attribute không đúng định dạng',
                'email'=>':attribute không đúng định dạng email',
                'image'=>':attribute upload phải là ảnh (jpg,png,svg,gif)',
                'not_in'=>'Chưa chọn :attribute '
            ],
            [
                'mobile'=>'Số điện thoại',
                'email'=>'Email',
                'user_name'=>'Tên tài khoản',
                'first_name'=>'Tên',
                'last_name'=>'Họ',
                'province'=>'Thành phố, tỉnh',
                'district'=>'Quận, huyện',
                'ward'=>'Khu vực',
                'image'=>'Ảnh đại diện',
                'address'=>'Địa chỉ'
            ]
        );
        if($validated->passes()){
            if($request->hasFile('image')){
                $image=$request->image;
                $nameimg=$image->getClientOriginalName();
                $image->move('images/user',$nameimg);
                $idimg=DB::table('tbl_image')->insertGetId(['ref_id'=>0,'type'=>1,'path'=>$nameimg]);
                $request->avatar_path=$idimg;
                $request->active=1;
                DB::table('tbl_user')->insert([
                    'user_name'=>$request->user_name,
                    'email'=>$request->email,
                    'first_name'=>$request->first_name,
                    'last_name'=>$request->last_name,
                    'mobile'=>$request->mobile,
                    'province'=>$request->province,
                    'district'=>$request->district,
                    'ward'=>$request->ward,
                    'address'=>$request->address,
                    'avatar_path'=>$idimg,
                    'active'=>1
                ]);
            }
        }
        return response()->json(['error'=>$validated->getMessageBag()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=DB::table('tbl_user')->where('user_id',$id)->first();
        $province=DB::table('tbl_province')->get();
        $district_user=DB::table('tbl_district')->where('_province_id',$user->province)->get();
        $ward=DB::table('tbl_ward')->where('_district_id',$user->district)->get();
        return view('admin.user.edit',['user'=>$user,'province'=>$province,'district'=>$district_user,'ward'=>$ward]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $validated=Validator::make($request->all(),
            [
                'user_name'=>'bail|required|regex:/^[A-z0-9]*$/',
                'first_name'=>'required',
                'last_name'=>'required',
                'mobile'=>'required|bail|regex:/^0[0-9]{9,10}$/',
                'email'=>'required|email|bail',
                'district'=>'required|not_in:0',
                'province'=>'required|not_in:0',
                'ward'=>'required|not_in:0',
                'image'=>'sometimes|nullable|image',
                'address'=>'required'
            ],
            [
                'required'=>':attribute không được rỗng',
                'regex'=>':attribute không đúng định dạng',
                'email'=>':attribute không đúng định dạng email',
                'image'=>':attribute upload phải là ảnh (jpg,png,svg,gif)',
                'not_in'=>'Chưa chọn :attribute '
            ],
            [
                'mobile'=>'Số điện thoại',
                'email'=>'Email',
                'user_name'=>'Tên tài khoản',
                'first_name'=>'Tên',
                'last_name'=>'Họ',
                'province'=>'Thành phố, tỉnh',
                'district'=>'Quận, huyện',
                'ward'=>'Khu vực',
                'image'=>'Ảnh đại diện',
                'address'=>'Địa chỉ'
            ]
        ); 
        if($validated->fails()) return response()->json(['error'=>$validated->getMessageBag()]);
        if($request->hasFile('image')){
            $file=$request->image;
            $file->move('images',$file->getClientOriginalName());
            $img_id=DB::table('tbl_image')->insertGetId(
                [
                    'ref_id'=>0,
                     'type'=>1,
                     'path'=>$file->getClientOriginalName()
                ]
            );
            DB::table('tbl_user')->where('user_id',$id)->update(
                [
                    'user_name'=>$request->user_name,
                    'email'=>$request->email,
                    'first_name'=>$request->first_name,
                    'last_name'=>$request->last_name,
                    'mobile'=>$request->mobile,
                    'province'=>$request->province,
                    'district'=>$request->district,
                    'ward'=>$request->ward,
                    'address'=>$request->address,
                    'avatar_path'=>$img_id
                ]
            );
        }else{
            DB::table('tbl_user')->where('user_id',$id)->update(
                [
                    'user_name'=>$request->user_name,
                    'email'=>$request->email,
                    'first_name'=>$request->first_name,
                    'last_name'=>$request->last_name,
                    'mobile'=>$request->mobile,
                    'province'=>$request->province,
                    'district'=>$request->district,
                    'ward'=>$request->ward,
                    'address'=>$request->address,
                ]
            );
        }
        return redirect('/user');
    }
    public function validate_edit(Request $request){
        $validated=Validator::make($request->all(),
            [
                'user_name'=>'bail|required|regex:/^[A-z0-9]*$/',
                'first_name'=>'required',
                'last_name'=>'required',
                'mobile'=>'required|bail|regex:/^0[0-9]{9,10}$/',
                'email'=>'required|email|bail',
                'district'=>'required|not_in:0',
                'province'=>'required|not_in:0',
                'ward'=>'required|not_in:0',
                'address'=>'required',
                'image'=>'sometimes|nullable|image'
            ],
            [
                'required'=>':attribute không được rỗng',
                'regex'=>':attribute không đúng định dạng',
                'email'=>':attribute không đúng định dạng email',
                'image'=>':attribute upload phải là ảnh (jpg,png,svg,gif)',
                'not_in'=>'Chưa chọn :attribute '
            ],
            [
                'mobile'=>'Số điện thoại',
                'email'=>'Email',
                'user_name'=>'Tên tài khoản',
                'first_name'=>'Tên',
                'last_name'=>'Họ',
                'province'=>'Thành phố, tỉnh',
                'district'=>'Quận, huyện',
                'ward'=>'Khu vực',
                'image'=>'Ảnh đại diện',
                'address'=>'Địa chỉ'
            ]
        );
        if($validated->fails()) return response()->json(['error'=>$validated->getMessageBag()]);
        return response()->json(['success'=>'validate success']);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('tbl_user')->where('user_id',$id)->delete();
        return redirect('/user');
    }
}

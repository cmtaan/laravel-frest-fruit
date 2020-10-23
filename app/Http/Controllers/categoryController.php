<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_cate=DB::table('tbl_category')->join('tbl_image','tbl_category.image_path','=','tbl_image.image_id')->orderBy('category_id','desc')->get();
        return view('admin.category.index',['list_cate'=>$list_cate]);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list_cate=DB::table('tbl_category')->get()->toArray(); 
        $list_cate=$this->cate_tree($list_cate);
        return view('admin.category.add',['list_cate'=>$list_cate]);
    }
    public function cate_tree($data,$parent_id=0,$level=0){
        $data_result=[];
        foreach ($data as $key => $value) {
           if($value->category_parent_id==$parent_id){
               $data[$key]->level=$level;
               array_push($data_result,$data[$key]);
               $id_cate=$value->category_id;
               unset($data[$key]);
               $child=$this->cate_tree($data,$id_cate,$level+1);
               $data_result=array_merge($data_result,$child);
           }
        }
        return $data_result;
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
                'category_name'=>'required|bail',
                'description'=>'required',
                'image'=>'image'
            ],
            [
                'required'=>':attribute không được bỏ rỗng',
                'image'=>':attribute phải là ảnh (jpeg,gif,png,svg)'
            ],
            [
                'category_name'=>'Tên danh mục',
                'description'=>'Mô tả danh mục',
                'image'=>'File upload'
            ]
        );
       
           
        if($validated->passes()){
            $file=$request->image;
            $file->move('images/',$file->getClientOriginalName());
            $id_img=DB::table('tbl_image')->insertGetId(['ref_id'=>0,'type'=>2,'path'=>$file->getClientOriginalName()]);
           
            if($request->category_parent_id=="" || $request->category_parent_id==null){
                $request->category_parent_id=0;
            }
            DB::table('tbl_category')->insert(
                [
                    'category_name'=>$request->category_name,'category_parent_id'=>$request->category_parent_id,'description'=>$request->description,'status'=>1,'image_path'=>$id_img
                ]);
            return response()->json(['success'=>'Add new category success']);
        }
        return response()->json(['error'=>$validated->getMessageBag(),'data'=>['name'=>$request->category_name,'description'=>$request->description]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cate=DB::table('tbl_category')->where('category_id',$id)->first();
        $list_cate=DB::table('tbl_category')->get()->toArray();
        $list_cate=$this->cate_tree($list_cate);
        return view('admin.category.edit',['cate'=>$cate,'list_cate'=>$list_cate]);
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
            'category_name'=>'required|bail',
            'description'=>'required',
            'image'=>'sometimes|nullable|image'
        ],
        [
            'required'=>':attribute không được bỏ rỗng',
            'image'=>':attribute phải là ảnh (jpeg,gif,png,svg)'
        ],
        [
            'category_name'=>'Tên danh mục',
            'description'=>'Mô tả danh mục',
            'image'=>'File upload'
        ]
    );
   
       
    if($validated->passes()){
        if($request->hasFile('image')){
            $file=$request->image;
            $file->move('images/',$file->getClientOriginalName());
            $id_img=DB::table('tbl_image')->insertGetId(['ref_id'=>0,'type'=>2,'path'=>$file->getClientOriginalName()]);
        }
        
        if($request->category_parent_id=="" || $request->category_parent_id==null){
            $request->category_parent_id=0;
        }

        if($request->hasFile('image')){
           DB::table('tbl_category')->where('category_id',$id)->update(
               [
                   'category_name'=>$request->category_name,
                    'category_parent_id'=>$request->category_parent_id,
                    'description'=>$request->description,'status'=>1,
                    'image_path'=>$id_img]);
        }else{
            DB::table('tbl_category')->where('category_id',$id)->update(
                [   
                    'category_name'=>$request->category_name,
                     'category_parent_id'=>$request->category_parent_id,
                    'description'=>$request->description,'status'=>1
                ]);
        }

       return redirect('/category');
    }
    return response()->json(['error'=>$validated->getMessageBag(),'data'=>$request->all()]);
    }

    public function validatededit(Request $request){
        $validated=Validator::make($request->all(),
        [
            'category_name'=>'required|bail',
            'description'=>'required',
            'image'=>'sometimes|nullable|image'
        ],
        [
            'required'=>':attribute không được bỏ rỗng',
            'image'=>':attribute phải là ảnh (jpeg,gif,png,svg)'
        ],
        [
            'category_name'=>'Tên danh mục',
            'description'=>'Mô tả danh mục',
            'image'=>'File upload'
        ]
        );
        if($validated->passes()){
            return response()->json(['success'=>'Success']);
        }
            return response()->json(['error'=>$validated->getMessageBag()]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $childCategory=DB::table('tbl_category')->where('category_parent_id',$id)->get()->toArray();
        $childProduct=DB::table('tbl_product')->where('category_id',$id)->get()->toArray();

        if(!empty($childCategory) || !empty($childProduct) ) return response()->json(['error'=>'Danh mục còn danh mục hoặc sản phẩm con']);
        DB::table('tbl_category')->where('category_id',$id)->delete();
        return response()->json(['success'=>'Delete success']);

    }
}

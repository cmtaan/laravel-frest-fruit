<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class provinceController extends Controller
{
    public function get_district(Request $request,$idDistrict){
        $district=DB::table('tbl_district')->where('_province_id',$idDistrict)->get();
        return response()->json(['district'=>$district]);
    }
}

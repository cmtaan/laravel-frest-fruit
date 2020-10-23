<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class districtController extends Controller
{ 
    function get_ward(Request $request,$idDistrict){
        $ward=DB::table('tbl_ward')->where('_district_id',$idDistrict)->get();
        return response()->json(['ward'=>$ward]);
    }
}

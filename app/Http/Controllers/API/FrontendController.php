<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function Frontend(Request $request){
        try {
            $get_all_category = NewsCategory::all();
            return response()->json(['status'=>200,'data'=>$get_all_category]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

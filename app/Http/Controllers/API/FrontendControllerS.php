<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsCategory;

class FrontendControllerS extends Controller
{
    public function Frontend(Request $request){
        try {
            dd('check fro all');
            $get_all_category = NewsCategory::all();
            return response()->json(['status'=>200,'data'=>$get_all_category]);
        } catch (\Throwable $th) {
            dd($th);
            //throw $th;
        }
    }
}

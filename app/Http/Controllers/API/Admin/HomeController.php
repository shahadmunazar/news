<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function userDetails(Request $request){
        return response()->json(['user' => auth()->user()]);
    }
}

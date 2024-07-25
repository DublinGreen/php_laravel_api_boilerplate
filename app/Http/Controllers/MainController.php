<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\Promotion;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    
    public function promotions()
    {
        $obj = Promotion::orderBy('title', 'ASC')->get();
        return response(['data' => $obj, 'message' => 'promotion data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function blog()
    {
        $obj = Post::orderBy('title', 'ASC')->get();
        return response(['data' => $obj, 'message' => 'all promotion data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function blogById($id)
    {
        $obj = Post::find($id);
        if(!empty($obj)){
            return response(['data' => $obj, 'message' => 'single post data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to get post data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

}
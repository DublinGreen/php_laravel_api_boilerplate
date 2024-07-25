<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\Catergory;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    
    public function categories()
    {
        $obj = Catergory::orderBy('title', 'ASC')->get();
        return response(['data' => $obj, 'message' => 'category data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required',
            'slug'     => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();

        $title = $input['title'];
        $slug = $input['slug'];

        $obj = Catergory::create([
            'uuid'         => Uuid::uuid4(),
            'title'   => $title,
            'last_name'    => $last_name,
            'slug'        => $slug,
            'created_at'   => Carbon::now(),
        ]);
        $saved = $obj->save();

        return response(['data' => $obj, 'message' => 'created category data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_CREATED')]);
    }

    public function edit(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required',
            'slug'     => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();

        $title = $input['title'];
        $slug = $input['slug'];

        $obj = Category::find($id);
        if(empty($obj)){
            return response(['data' => [], 'message' => 'unable to update category data, invalid id', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }

        $obj->title = $title;
        $obj->slug = $slug;
        $obj->updated_at = Carbon::now();
        $saved = $obj->save();
        
        return response(['data' => $obj, 'message' => 'single category data updated', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function delete($id)
    {
        $obj = Category::find($id);
        if(!empty($obj)){
            $obj->delete();
            return response(['data' => $obj, 'message' => 'category data deleted', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to category data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

    public function categoryById($id)
    {
        $obj = Category::find($id);
        if(!empty($obj)){
            return response(['data' => $obj, 'message' => 'single category data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to get category data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

}
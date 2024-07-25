<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\Brand;
use Illuminate\Support\Facades\Hash;

class BrandController extends Controller
{
    
    public function brands()
    {
        $obj = Brand::orderBy('title', 'ASC')->get();
        return response(['data' => $obj, 'message' => 'brand data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
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

        $obj = Brand::create([
            'uuid'         => Uuid::uuid4(),
            'title'   => $title,
            'last_name'    => $last_name,
            'slug'        => $slug,
            'created_at'   => Carbon::now(),
        ]);
        $saved = $obj->save();

        return response(['data' => $obj, 'message' => 'created brand data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_CREATED')]);
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

        $obj = Brand::find($id);
        if(empty($obj)){
            return response(['data' => [], 'message' => 'unable to update brand data, invalid id', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }

        $obj->title = $title;
        $obj->slug = $slug;
        $obj->updated_at = Carbon::now();
        $saved = $obj->save();
        
        return response(['data' => $obj, 'message' => 'single brand data updated', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function delete($id)
    {
        $obj = Brand::find($id);
        if(!empty($obj)){
            $obj->delete();
            return response(['data' => $obj, 'message' => 'brand data deleted', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to brand data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

    public function brandById($id)
    {
        $obj = Brand::find($id);
        if(!empty($obj)){
            return response(['data' => $obj, 'message' => 'single brand data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to get brand data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{
    
    public function products()
    {
        $obj = Product::orderBy('title', 'ASC')->get();
        return response(['data' => $obj, 'message' => 'product data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_uuid'    => 'required',
            'uuid'             => 'required',
            'title'            => 'required',
            'price'            => 'required|numeric',
            'description'      => 'required',
            'metadata'         => 'required',
            'created_at'       => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $title = $input['title'];
        $price = $input['price'];
        $description = $input['description'];
        $metadata = $input['metadata'];
        $created_at = $input['created_at'];

        $obj = Product::create([
            'uuid'         => Uuid::uuid4(),
            'title'        => $title,
            'price'        => $price,
            'description'  => $description,
            'metadata'     => $metadata,
            'created_at'   => Carbon::now(),
        ]);
        $saved = $obj->save();

        return response(['data' => $obj, 'message' => 'created product data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_CREATED')]);
    }

    public function edit(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'category_uuid'    => 'required',
            'uuid'             => 'required',
            'title'            => 'required',
            'price'            => 'required|numeric',
            'description'      => 'required',
            'metadata'         => 'required',
            'created_at'       => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $title = $input['title'];
        $price = $input['price'];
        $description = $input['description'];
        $metadata = $input['metadata'];
        $created_at = $input['created_at'];

        $obj = Product::find($id);
        if(empty($obj)){
            return response(['data' => [], 'message' => 'unable to update product data, invalid id', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }

        $obj->title = $title;
        $obj->price = $price;
        $obj->description = $description;
        $obj->metadata = $metadata;
        $obj->updated_at = Carbon::now();
        $saved = $obj->save();
        
        return response(['data' => $obj, 'message' => 'single product data updated', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function delete($id)
    {
        $obj = Product::find($id);
        if(!empty($obj)){
            $obj->delete();
            return response(['data' => $obj, 'message' => 'product data deleted', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to product data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

    public function productById($id)
    {
        $obj = Product::find($id);
        if(!empty($obj)){
            return response(['data' => $obj, 'message' => 'single product data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to get product data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

}
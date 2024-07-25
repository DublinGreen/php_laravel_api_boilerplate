<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Hash;

class OrderStatusController extends Controller
{
    
    public function orderStatuses()
    {
        $obj = OrderStatus::orderBy('title', 'ASC')->get();
        return response(['data' => $obj, 'message' => 'order status data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $title = $input['title'];

        $obj = Brand::create([
            'uuid'         => Uuid::uuid4(),
            'title'   => $title,
            'created_at'   => Carbon::now(),
        ]);
        $saved = $obj->save();

        return response(['data' => $obj, 'message' => 'created order status data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_CREATED')]);
    }

    public function edit(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $title = $input['title'];

        $obj = OrderStatus::find($id);
        if(empty($obj)){
            return response(['data' => [], 'message' => 'unable to update order status data, invalid id', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }

        $obj->title = $title;
        $obj->updated_at = Carbon::now();
        $saved = $obj->save();
        
        return response(['data' => $obj, 'message' => 'single order status data updated', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function delete($id)
    {
        $obj = OrderStatus::find($id);
        if(!empty($obj)){
            $obj->delete();
            return response(['data' => $obj, 'message' => 'order status data deleted', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to order status data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

    public function orderStatusById($id)
    {
        $obj = OrderStatus::find($id);
        if(!empty($obj)){
            return response(['data' => $obj, 'message' => 'single order status data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to get order status data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

}
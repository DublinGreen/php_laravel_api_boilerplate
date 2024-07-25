<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;

class PaymentController extends Controller
{
    
    public function payments()
    {
        $obj = Payment::orderBy('uuid', 'ASC')->get();
        return response(['data' => $obj, 'message' => 'payment data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type'    => 'required',
            'details' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $type = $input['type'];
        $details = $input['details'];

        $obj = Payment::create([
            'uuid'         => Uuid::uuid4(),
            'type'   => $type,
            'details'    => $details,
            'created_at'   => Carbon::now(),
        ]);
        $saved = $obj->save();

        return response(['data' => $obj, 'message' => 'created payment data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_CREATED')]);
    }

    public function edit(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'type'    => 'required',
            'details' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();

        $type = $input['type'];
        $details = $input['details'];

        $obj = Payment::find($id);
        if(empty($obj)){
            return response(['data' => [], 'message' => 'unable to update payment data, invalid id', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }

        $obj->type = $type;
        $obj->details = $details;
        $obj->updated_at = Carbon::now();
        $saved = $obj->save();
        
        return response(['data' => $obj, 'message' => 'single payment data updated', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function delete($id)
    {
        $obj = Payment::find($id);
        if(!empty($obj)){
            $obj->delete();
            return response(['data' => $obj, 'message' => 'payment data deleted', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to payment data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

    public function paymentById($id)
    {
        $obj = Payment::find($id);
        if(!empty($obj)){
            return response(['data' => $obj, 'message' => 'single payment data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to get payment data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

}
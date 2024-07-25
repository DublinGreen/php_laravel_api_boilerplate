<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\PasswordResetToken;
use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    
    public function index()
    {
        $obj = User::orderBy('email', 'ASC')->get();
        return response(['data' => $obj, 'message' => 'user data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function getById($id)
    {
        $obj = User::find($id);
        if(!empty($obj)){
            return response(['data' => $obj, 'message' => 'single user data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to get user data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

    public function orders($id)
    {
        $obj = Order::Where('user_id', $id)->get();

        if(!empty($obj)){
            return response(['data' => $obj, 'message' => "get user orders", 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to get user orders', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
        
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'is_marketing'  => 'required',
            'email'         => 'required|email|unique:users,email',
            'address'       => 'required',
            'phone_number'  => 'required',
            'password'      => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();

        $first_name = $input['first_name'];
        $last_name = $input['last_name'];
        $email = $input['email'];
        $is_marketing = $input['is_marketing'];
        $address = $input['address'];
        $phone_number = $input['phone_number'];
        $password = $input['password'];
        $hashPassword = Hash::make($password);

        $obj = User::create([
            'uuid'         => Uuid::uuid4(),
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'email'        => $email,
            'email_verified_at' => null,
            'password'     => $hashPassword,
            'is_marketing' => $is_marketing,
            'is_admin'     => \App\Enums\AdminStatus::NO,
            'address'      => $address,
            'phone_number' => $phone_number,
            'created_at'   => Carbon::now(),
            'avatar'       => null,
            'rememberToken'=> \App\Enums\MarketingStatus::NO,
        ]);
        $saved = $obj->save();

        return response(['data' => $obj, 'message' => 'created user data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_CREATED')]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();

        $email = $input['email'];
        $password = $input['password'];

        $obj = User::where('email', $email)->first();
        if(!empty($obj)){
            $check = Hash::check($password, $obj->password);
            if($check){
                $userObj = new User();
                $jwtToken = ['token' => $userObj->generateToken($obj)];
                return response(['data' => $jwtToken, 'message' => 'user login successful, token generated', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
            }
        }else{
            return response(['data' => [], 'message' => 'email and password combination incorrect', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }

    }

    public function logout(Request $request)
    {

        $token = trim(substr($request->header('Authorization'), 6));// Remove Bearer String and single space

        if(!empty($token)){
            $tokenObj = PersonalAccessToken::where('token', $token)->first();
            $tokenObj->delete();
            
            return response(['data' => [], 'message' => 'user logout successful', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'token is not valid', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_UNAUTHORIZED')]);
        }

    }

    public function edit(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'first_name'        => 'required',
            'last_name'         => 'required',
            'email'             => 'required|email|unique:users,email',
            'address'           => 'required',
            'phone_number'      => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();

        $first_name = $input['first_name'];
        $last_name = $input['last_name'];
        $email = $input['email'];
        $address = $input['address'];
        $phone_number = $input['phone_number'];

        $obj = User::find($id);
        if(empty($obj)){
            return response(['data' => [], 'message' => 'unable to update user data, invalid id', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
        $obj->first_name = $first_name;
        $obj->last_name = $last_name;
        $obj->email = $email;
        $obj->address = $address;
        $obj->phone_number = $phone_number;
        $obj->updated_at = Carbon::now();
        $saved = $obj->save();
        
        return response(['data' => $obj, 'message' => 'single user data updated', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function delete($id)
    {
        $obj = User::find($id);
        if(!empty($obj)){
            $obj->delete();
            return response(['data' => $obj, 'message' => 'user data deleted', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'unable to user user data', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

    public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $email = $input['email'];

        $obj = User::where('email', $email)->first();
        $emailToken = urlencode(Hash::make($obj->uuid . $obj->email));

        if(!empty($obj)){
            $passwordResetTokenObj = PasswordResetToken::create([
                'email' => $obj->email,
                'token' => $emailToken,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ]);
            $saved = $passwordResetTokenObj->save();
            return response(['data' => $emailToken, 'message' => 'password reset token generated and email sent', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'invalid user email', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

    public function resetPasswordToken(Request $request){
        $validator = Validator::make($request->all(), [
            'email'                 => 'required|email',
            'password'              => 'required|string|confirmed',
            'password_confirmation' => 'required',
            'token'                 => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $email = $input['email'];
        $password_confirmation = $input['password_confirmation'];
        $password = $input['password'];
        $hashPassword = Hash::make($password);
        $token = $input['token'];

        $passwordResetTokenObj = PasswordResetToken::where('token', $token)->first();

        if(!empty($passwordResetTokenObj)){
                    
            $obj = User::where('email', $email)->first();
            $obj->password = $hashPassword;
            $obj->updated_at = Carbon::now();
            $saved = $obj->save();

            $passwordResetTokenObj->delete();
            $response = ['token' => $token ,'email' => $email];
            return response(['data' => $response, 'message' => 'password reset success, login with new password', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
        }else{
            return response(['data' => [], 'message' => 'invalid password reset token', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

}
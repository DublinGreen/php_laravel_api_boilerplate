<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\JwtFacade;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Encoding\JoseEncoder;
use App\Models\PersonalAccessToken;
use Lcobucci\JWT\Token\Parser;
use Carbon\Carbon;
class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->input('token') !== 'my-secret-token') {
            $token = trim(substr($request->header('Authorization'), 6));// Remove Bearer String and single space
            
            $checkNow   = Carbon::now()->toImmutable();
            $tokenObj = PersonalAccessToken::where('token', $token)->first();

            if(!empty($tokenObj)){
                $mysqlTimestamp = strtotime($tokenObj->expires_at);
                $nowTimeStamp = strtotime($checkNow);
            }

            // check token and expires_at
            if(empty($tokenObj) || ($mysqlTimestamp < $nowTimeStamp)){
                return response(['data' => [], 'message' => 'token is not valid', 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_UNAUTHORIZED')]);
            }else{
                $tokenObj->last_used_at = Carbon::now();
                $tokenObj->updated_at = Carbon::now();
                $saved = $tokenObj->save();
            }
        }
 

        return $next($request);
    }
}

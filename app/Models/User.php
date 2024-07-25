<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;
use Ramsey\Uuid\Uuid;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid', 
        'first_name', 
        'last_name', 
        'is_admin', 
        'is_marketing', 
        'email', 
        'avatar', 
        'address', 
        'phone_number', 
        'created_at', 
        'updated_at', 
        'last_login_at',
        'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'id',
        'password',
        'email_verified_at'
    ];

    public function generateToken($obj){
        $tokenBuilder = (new Builder(new JoseEncoder(), ChainedFormatter::default()));
        $algorithm    = new Sha256();
        $signingKey   = InMemory::plainText(Hash::make(env('JWT_KEY')));

        $now   = Carbon::now()->toImmutable();
        $token = $tokenBuilder
            // Configures the issuer (iss claim)
            ->issuedBy('http://' . empty($_SERVER['SERVER_NAME']) ? env('LOCAL_SERVER_URL') : $_SERVER['SERVER_NAME'])
            // Configures the audience (aud claim)
            ->issuedBy('http://' . empty($_SERVER['SERVER_NAME']) ? env('LOCAL_SERVER_URL') : $_SERVER['SERVER_NAME'])
            // Configures the subject of the token (sub claim)
            ->relatedTo('component1')
            // Configures the id (jti claim)
            ->identifiedBy('4f1g23a12aa')
            // Configures the time that the token was issue (iat claim)
            ->issuedAt($now)
            // Configures the time that the token can be used (nbf claim)
            ->canOnlyBeUsedAfter($now->modify('+1 minute'))
            // Configures the expiration time of the token (exp claim)
            ->expiresAt($now->modify('+1 hour'))
            // Configures a new claim, called "uid"
            ->withClaim('uid', $obj->uuid)
            // Configures a new header, called "foo"
            ->withHeader('foo', 'bar')
            // Builds a new token
            ->getToken($algorithm, $signingKey);
 
        $tokenObj = PersonalAccessToken::create([
            'tokenable_type' => 'jwt',
            'tokenable_id' => $obj->id,
            'name' => $obj->email,
            'token' => $token->toString(),
            'abilities' => 'admin, web',
            'expires_at' => $now->modify('+1 hour'),
            'last_used_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);
        $saved = $tokenObj->save();
        return $token->toString();
    }

}

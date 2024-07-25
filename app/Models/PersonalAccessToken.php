<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalAccessToken extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'tokenable_type',
      'tokenable_id',
      'name',
      'token',
      'abilities',
      'last_used_at',
      'expires_at',
      'created_at',
      'updated_at'
    ];
}
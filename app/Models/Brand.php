<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'uuid',
      'title',
      'slug',
      'created_at',
      'updated_at'
    ];
}
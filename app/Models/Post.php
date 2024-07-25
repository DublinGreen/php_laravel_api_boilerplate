<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'uuid',
      'title',
      'slug',
      'content',
      'metadata' => 'array',
      'created_at',
      'updated_at'
    ];
}
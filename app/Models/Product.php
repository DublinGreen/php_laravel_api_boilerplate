<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'category_uuid',
      'uuid',
      'title',
      'price',
      'description',
      'metadata' => 'array',
      'deleted_at',
      'created_at',
      'updated_at'
    ];
}
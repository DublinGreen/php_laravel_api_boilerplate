<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'uuid',
      'name',
      'path',
      'size',
      'type',
      'created_at',
      'updated_at'
    ];
}
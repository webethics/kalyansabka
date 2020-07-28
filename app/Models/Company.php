<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
  //  use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
     ];

    protected $fillable = [
        'title',
        'slug',
        'created_at',
        'updated_at',
    ];
	
	
}

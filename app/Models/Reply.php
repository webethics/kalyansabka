<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
	//use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
     ];

    protected $fillable = [
        'user_id',
        'complaint_id',
        'reply',
        'created_at',
		'updated_at',
  
    ];
	
	public function complaint() {
        return $this->belongsTo('App\Models\Complaints', 'id');
	}
	public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
	}
}

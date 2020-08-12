<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaints extends Model
{
	use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
     ];

    protected $fillable = [
        'user_id',
        'ticket_id',
        'subject',
        'message',
        'status',
        'created_at',
        'updated_at',
    ];
	
	public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
	}
	public function replies() {
        return $this->hasMany('App\Models\Reply', 'complaint_id');
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDocuments extends Model
{
    //use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'aadhaar_front',
        'aadhaar_back',
        'pan_card',
        'user_id',
        'created_at',
        'updated_at',
    ];
	public function users() {
		return $this->HasOne(User::class);
	}
}

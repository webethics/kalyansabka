<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserNominees extends Model
{
    //use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'relation',
    ];
	public function users() {
		return $this->HasOne(User::class);
	}
}

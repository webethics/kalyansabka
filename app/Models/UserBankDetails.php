<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBankDetails extends Model
{
    //use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'bank_name',
        'account_name',
        'account_number',
        'ifsc_code',
        'user_id',
        'created_at',
        'updated_at',
    ];
	public function users() {
		return $this->HasOne(User::class);
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeHistory extends Model
{
    protected $fillable = [
        'user_id',
        'referral_id',
        'mode',
        'amount',
        'transaction_id',
        'comment',
        'status'
    ];
	
	public function request_changes() {
		return $this->hasOne('App\Models\WithdrawalRequestCharges','request_id');
	}
	
	/* public function referred_data() {
		return $this->hasOne('App\Models\User','id');
	} */
	
	public function user() {
		return $this->belongsTo('App\Models\User','referral_id');
	}
	
}

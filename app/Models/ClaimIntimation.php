<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClaimIntimation extends Model
{
    use SoftDeletes;
	
    protected $dates = [
        'created_at',
        'updated_at',
    ];

	
    protected $fillable = [
        'policy_number',
        'initimation_aadhar_number',
		'initimation_mobile_number',
        'name',
        'aadhar_number',
        'mobile_number',
        'status',
        'description'
    ];

    public function claimMedia()
    {
        return $this->hasMany('App\Models\ClaimMedia','claim_intimation_id');
    }
	
	public function user() {
        return $this->belongsTo('App\Models\User', 'policy_number');
	}
}

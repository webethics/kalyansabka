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
        'claim_request_id',
        'policy_number',
        'initimation_aadhar_number',
		'initimation_mobile_number',
        'name',
        'aadhar_number',
        'mobile_number',
        'status'
    ];

    public function claimMedia()
    {
        return $this->hasMany('App\Models\ClaimMedia','claim_intimation_id');
    }
}

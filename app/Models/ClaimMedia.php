<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClaimMedia extends Model
{
    use SoftDeletes;
	
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
    	'original_name',
        'media',
        'claim_intimation_id',
        'upload_type'
    ];

    public function claimIntimation()
    {
        return $this->belongsTo('App\Models\ClaimIntimation','claim_intimation_id');
    }
}

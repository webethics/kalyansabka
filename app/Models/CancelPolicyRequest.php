<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CancelPolicyRequest extends Model
{
    use SoftDeletes;
	
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'user_id',
        'plan_id',
		'refund_status'
    ];
	
	public function user() {
		return $this->belongsTo('App\Models\User','user_id');
	}

	public function getFullNameAttribute()
    {
        return ucfirst("{$this->first_name} {$this->last_name}");
    }
	
}

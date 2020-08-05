<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class TempUpgradeRequest extends Model
{
    use SoftDeletes;
	
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'user_id',
        'plan_id',
		'upgrade_tax_id',
		'amount',
		'status',
        'request_expired'
    ];

    protected $appends = ['expired_view_format'];

    public function upgradeTax() {
		return $this->belongsTo('App\Models\UpgradeTax','upgrade_tax_id');
	}

    public function user() {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function getExpiredViewFormatAttribute()
    {
        return Carbon::parse($this->created_at)->format('d F Y');
    }
}

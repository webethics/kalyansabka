<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UpgradeTax extends Model
{
    use SoftDeletes;
	
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'no_of_days',
		'cost',
		'locking_period'
    ];

    public function tempUpgrade() {
		return $this->hasMany('App\Models\TempUpgradeRequest','upgrade_tax_id');
	}
}

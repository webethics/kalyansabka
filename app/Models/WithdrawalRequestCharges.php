<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawalRequestCharges extends Model
{
    public $timestamps = false;
	protected $table = 'withdrawal_request_charges';
	protected $fillable = [
        'user_id',
        'request_id',
        'withdrawal_amount',
        'tds_deduction',
        'admin_charges',
        'deposit_to_bank',
        'tds_percent',
        'admin_percent',
    ];
	
	/* public function request_changes() {
		return $this->belonsTo('App\Models\WithdrawalRequest','income_history_id');
	} */
}

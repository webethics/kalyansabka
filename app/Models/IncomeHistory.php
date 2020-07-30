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
        'comment'
    ];
}

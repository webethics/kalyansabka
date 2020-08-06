<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPayment extends Model
{
    use SoftDeletes;

    protected $dates = [
        'updated_at',
        'created_at'
    ];

    protected $fillable = [
        'user_id',
        'plan_id',
        'amount',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

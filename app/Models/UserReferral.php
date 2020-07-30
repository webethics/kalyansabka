<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserReferral extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'ref_user_id1',
        'ref_user_id2',
        'ref_user_id3',
        'ref_user_id4',
        'ref_user_id5'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

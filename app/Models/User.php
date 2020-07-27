<?php

namespace App\Models;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;


class User extends Authenticatable
{
    use  Notifiable;
	use Billable;
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
    ];

    protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password',
		'address',
		'role_id',
		'mobile_number',
		'aadhar_number',
		'status',
		'date_of_birth',
		'age',
		'price',
		'state_id',
		'district_id',
		'price',
		'remember_token',
		'refered_by',
		'hard_copy_certificate',
        'certificate_status',
		'verify_token' 
    ];

    protected $appends = ['full_name'];

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
	
	public function bankDetails()
    {
    	//return $this->hasOne('App\Models\UserBankDetails','user_id');
		return $this->belongsTo(UserBankDetails::class, 'user_id');
    }
	public function role() {
        return $this->belongsTo(App\Models\Role, 'role_id');
    }

    public function city(){
        return $this->belongsTo('App\Models\CityLists', 'district_id');
    }

    public function state(){
        return $this->belongsTo('App\Models\StateList', 'state_id');
    }

    public function tempRequestUser() {
        return $this->hasMany('App\Models\TempRequestUser','user_id');
    }

    public function getFullNameAttribute()
    {
        return ucfirst("{$this->first_name} {$this->last_name}");
    }
   
}

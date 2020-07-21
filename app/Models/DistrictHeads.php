<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistrictHeads extends Model
{
	public $timestamps = false;
    protected $table = 'district_heads';
	protected $fillable = [
        'district_id',
        'user_id',
       
    ];
}
?>
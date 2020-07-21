<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StateHeads extends Model
{
	public $timestamps = false;
    protected $table = 'state_heads';
	protected $fillable = [
        'state_id',
        'user_id',
       
    ];
}
?>
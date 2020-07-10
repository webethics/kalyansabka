<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StateList extends Model
{
    public $timestamps = false;
    protected $table = 'state_list';
}
?>
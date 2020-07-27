<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CityLists extends Model
{
	public $timestamps = false;
    protected $table = 'city_lists';

    public function user() {
        return $this->hasMany('App\Models\User','district_id');
    }
  
}
?>
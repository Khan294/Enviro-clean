<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fence extends Model {
	protected $fillable = ['fenceName', 'address', 'lng', 'lat', 'rad', 'site_id'];

	public function fenceClocks(){
        return $this->hasMany('\App\FenceClock');
    }

	public function site() {
        return $this->belongsTo('\App\Site');
    }
}

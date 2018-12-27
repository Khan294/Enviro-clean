<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model {

    protected $fillable = ['siteName', 'address', 'lng', 'lat', 'rad', 'region_id', 'siteName'];

	public function region() {
        return $this->belongsToMany('\App\Region');
    }

    public function fences(){
        return $this->hasMany('\App\Fence');
    }

    public function siteClocks(){
        return $this->hasMany('\App\SiteClock');
    }

    public function shifts() {
        return $this->belongsToMany('\App\Shift');
    }

    /*
    public function violations() {
        return $this->belongsToMany('\App\Violation');
    }*/
}

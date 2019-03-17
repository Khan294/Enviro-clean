<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model {
	protected $fillable = ['regionName'];

  public function users(){
        return $this->hasMany('\App\User');
    }

  public function sites(){
      return $this->hasMany('\App\Site');
  }
}

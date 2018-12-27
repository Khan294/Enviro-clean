<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model {
	protected $fillable = ['regionName', 'user_id'];

	public function user() {
        return $this->belongsToMany('\App\User');
  }

  public function sites(){
      return $this->hasMany('\App\Site');
  }
}

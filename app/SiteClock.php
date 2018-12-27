<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteClock extends Model {
	protected $fillable = ['type', 'user_id', 'site_id'];

	public function site() {
        return $this->belongsToMany('\App\Site');
    }
}

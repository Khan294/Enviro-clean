<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model {
	protected $fillable = ['user_id', 'dateTag', 'timTag', 'isApproved'];

	public function sites() {
        return $this->belongsToMany('\App\Site');
    }
}

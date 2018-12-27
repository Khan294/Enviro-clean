<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FenceClock extends Model {
	protected $fillable = ['type', 'user_id', 'fence_id'];

	public function fence() {
        return $this->belongsToMany('\App\Fence');
    }
}

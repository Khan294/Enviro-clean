<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Violation extends Model {

	protected $fillable = ['infraction_id', 'fence_id', 'user_id', 'image', 'unitNumber', 'photo_id'];

	public function infraction() {
        return $this->belongsTo('\App\Infraction');
    }

    public function user() {
        return $this->belongsTo('\App\User');
    }

    public function fence() {
        return $this->belongsTo('\App\Fence');
    }

    public function photo() {
        return $this->belongsTo('\App\Photo');
    }
}

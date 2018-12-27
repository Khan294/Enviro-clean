<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model {
	protected $fillable = ['chatName'];

	public function users() {
        return $this->belongsToMany('\App\User');
    }
}

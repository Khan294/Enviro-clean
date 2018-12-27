<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Infraction extends Model {
	protected $fillable = ['infractionName', 'priority'];
}

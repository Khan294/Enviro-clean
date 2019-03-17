<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'image', 'wage', 'contact', "region_id"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 'remember_token', 'password'];

    public function region() {
        return $this->belongsTo('\App\Region');
  }

    public function violations(){
        return $this->hasMany('\App\Violation');
    }

    public function chats() {
        return $this->belongsToMany('\App\Chat');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
  protected $fillable = ['photoType'];

  public function violations(){
    return $this->hasMany('\App\Violation');
  }
}

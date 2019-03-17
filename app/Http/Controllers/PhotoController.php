<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller {
    public function index() {
      return response()->json(Photo::all());
    }

}

<?php

namespace App\Http\Controllers;

use App\SiteClock;
use Illuminate\Http\Request;

class SiteClockController extends Controller {
    public function __construct() {
        $allowedRole= array('SUPER', 'MANAGER', 'VALET', 'CUSTOMEr');
        $this->middleware(['fhkAuth:super,none'], ['allow' => ['ALL'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:manager,api'], ['allow' => ['ALL'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:valet,api'], ['allow' => ['store'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:customer,api'], ['allow' => ['index', 'show'], 'restrict'=>$allowedRole]);
    }

    public function isValid($fields){
        return \Validator::make($fields, [
            'type' => 'required',
            'user_id' => 'required',
            'site_id' => 'required',
        ])->fails()? false: true;
    }

    public function index(Request $request) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(SiteClock::all());
    }

    public function show(Request $request, $id) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(SiteClock::find($id));
    }

    public function store(Request $request) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        if(!$this->isValid($request->all()))
            return response()->json(["error" => "Check your arguments."]);
        return response()->json(["status" => (new SiteClock($request->all()))->save()? "pass": "failed"]);
    }

    public function update(Request $request, $id) { // PUT/PATCH /route/{id}
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        if(!$this->isValid($request->all()))
            return response()->json(["error" => "Check your arguments."]);

        return response()->json(["status" => SiteClock::find($id)->update($request->all())? "pass": "failed"]);
    }

    public function destroy(Request $request, $id) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(["status" => SiteClock::find($id)->delete()? "pass": "failed"]);
    }

    public function create() { }
    public function edit($id) { }
}

<?php

namespace App\Http\Controllers;

use App\Region;
use Illuminate\Http\Request;

class RegionController extends Controller {
    public function __construct() {
        $allowedRole= array('SUPER', 'MANAGER', 'VALET', 'CUSTOMEr');
        $this->middleware(['fhkAuth:super,none'], ['allow' => ['ALL'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:manager,api'], ['allow' => ['index', 'show'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:valet,api'], ['allow' => ['index', 'show'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:customer,api'], ['allow' => ['index', 'show'], 'restrict'=>$allowedRole]);
    }

    public function isValid($fields){
        return \Validator::make($fields, [
            'regionName' => 'required',
            'user_id' => 'required',
        ])->fails()? false: true;
    }

    public function index(Request $request) {
        if(!$request->wantsJson())
            return view('region');
        return response()->json(Region::all());
    }

    public function show(Request $request, $id) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(Region::find($id));
    }

    public function store(Request $request) {
        if(!$this->isValid($request->all()))
            return response()->json(["error" => "Check your arguments."]);

        $res= new Region($request->all());

        return response()->json(["status" => $res->save()? "pass": "failed", "id"=>$res->id]);
    }

    public function update(Request $request, $id) { // PUT/PATCH /route/{id}
        if(!$this->isValid($request->all()))
            return response()->json(["error" => "Check your arguments."]);

        $res= Region::find($id);
        $data= $request->all();

        return response()->json(["status" => $res->update($data)? "pass": "failed"]);
    }

    public function destroy(Request $request, $id) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(["status" => Region::find($id)->delete()? "pass": "failed"]);
    }

    public function create() { }
    public function edit($id) { }
}

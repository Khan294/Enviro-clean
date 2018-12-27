<?php

namespace App\Http\Controllers;

use App\Infraction;
use Illuminate\Http\Request;

class InfractionController extends Controller {
    public function __construct() {
        $allowedRole= array('SUPER', 'MANAGER', 'VALET', 'CUSTOMEr');
        $this->middleware(['fhkAuth:super,none'], ['allow' => ['ALL'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:manager,api'], ['allow' => ['ALL'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:valet,api'], ['allow' => ['index', 'show'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:customer,api'], ['allow' => ['index', 'show'], 'restrict'=>$allowedRole]);
    }

    public function isValid($fields){
        return \Validator::make($fields, [
            'infractionName' => 'required',
            'priority' => 'required',
        ])->fails()? false: true;
    }

    public function index(Request $request) {
        if(!$request->wantsJson())
            return view('infraction');
        return response()->json(Infraction::all());
    }

    public function show(Request $request, $id) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(Infraction::find($id));
    }

    public function store(Request $request) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        if(!$this->isValid($request->all()))
            return response()->json(["error" => "Check your arguments."]);
        return response()->json(["status" => (new Infraction($request->all()))->save()? "pass": "failed"]);
    }

    public function update(Request $request, $id) { // PUT/PATCH /route/{id}
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        if(!$this->isValid($request->all()))
            return response()->json(["error" => "Check your arguments."]);

        return response()->json(["status" => Infraction::find($id)->update($request->all())? "pass": "failed"]);
    }

    public function destroy(Request $request, $id) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(["status" => Infraction::find($id)->delete()? "pass": "failed"]);
    }

    public function create() { }
    public function edit($id) { }
}

<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller {

    public function __construct() {
        $allowedRole= array('SUPER', 'MANAGER', 'VALET', 'CUSTOMEr');
        $this->middleware(['fhkAuth:super,none'], ['allow' => ['ALL'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:manager,api'], ['allow' => ['ALL'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:valet,api'], ['allow' => ['index', 'show'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:customer,api'], ['allow' => ['index', 'show'], 'restrict'=>$allowedRole]);
    }

    public function isValid($fields){
        return \Validator::make($fields, [
            'chatName' => 'required',
        ])->fails()? false: true;
    }

    public function index(Request $request) {
        if(!$request->wantsJson())
            return view('chat');
        return response()->json(Chat::with('users')->get());
    }

    public function chatPop(Request $request, $header) {
      $user= \Auth::user();
      return view('chatPop', ["header" => $header, "username" => $user->name, "id" => $user->id]);
    }

    public function show(Request $request, $id) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(Chat::find($id));
    }

    public function store(Request $request) {
        if(!$this->isValid($request->all()))
            return response()->json(["error" => "Check your arguments."]);

        $data= $request->all();
        $binds= null;
        if(array_key_exists('binds', $data)) {
          if($data["binds"]!=null) {
            $binds= explode(',', $data["binds"]);
            unset($data["binds"]);
          }
        }

        $res= new Chat($data);
        $status= "failed";
        $bindStatus="failed";
        
        if($res->save()) {
          $status= "pass";
          if($binds!=null)
            $bindStatus= $res->users()->sync($binds)? "pass": "failed";
        }
        return response()->json(["status" => $status, "id"=>$res->id, "binds" => $bindStatus]);
    }

    public function update(Request $request, $id) { // PUT/PATCH /route/{id}
        if(!$this->isValid($request->all()))
          return response()->json(["error" => "Check your arguments."]);

        $data= $request->all();
      
        $binds= null;
        if(array_key_exists('binds', $data)) {
          if($data["binds"]!=null) {
            $binds= explode(',', $data["binds"]);
            unset($data["binds"]);
          }
        }

        $res= Chat::find($id);
        $status= "failed";
        $bindStatus= "failed";

        if($res->update($data)) {
          $status= "pass";
          if($binds!=null)
            $bindStatus= $res->users()->sync($binds)? "pass": "failed";
        }

        return response()->json(["status" => $status, "id"=>$res->id, "binds" => $bindStatus]);
    }

    public function destroy(Request $request, $id) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(["status" => Chat::find($id)->delete()? "pass": "failed"]);
    }

    /*
    public function bindUser(Request $request, $id){
        return response()->json(["status" => Chat::find($id)->users()->sync($request->input('binds'))? "pass": "failed"]);
    }*/

    public function create() { }
    public function edit($id) { }
}

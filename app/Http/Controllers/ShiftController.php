<?php

namespace App\Http\Controllers;

use App\Shift;
use App\Site;
use Illuminate\Http\Request;

class ShiftController extends Controller {
    public function __construct() {
        $allowedRole= array('SUPER', 'MANAGER', 'VALET', 'CUSTOMEr');
        $this->middleware(['fhkAuth:super,none'], ['allow' => ['ALL'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:manager,api'], ['allow' => ['ALL'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:valet,api'], ['allow' => ['index', 'show', 'shiftFilter'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:customer,api'], ['allow' => ['index', 'show'], 'restrict'=>$allowedRole]);
    }

    public function isValid($fields){
        return \Validator::make($fields, [
            'user_id' => 'required',
            'dateTag' => 'required',
            'timTag' => 'required',
        ])->fails()? false: true;
    }

    public function index(Request $request) {
        if(!$request->wantsJson())
            return view('shift');
        return response()->json(Shift::with('sites')->orderBy('dateTag', 'ASC')->get());
    }

    public function shiftFilter(Request $request) {
      $d= $request->input();

      if(!array_key_exists("user_id", $d))
        return response()->json(["status" => "failed", "message" => "You must specify a user field!" ]);

      else if($d["all"]===true)
        return response()->json(Shift::with('sites')->where(['user_id' => $d["user_id"]])->get());

      else if($d["shift_id"])
        return response()->json(Shift::with('sites')->where(['user_id' => $d["user_id"], "id" => $d["shift_id"]])->get());

      else if($d["date"])
        return response()->json(Shift::with('sites')->where([
          ['user_id', '=', $d["user_id"]],
          ['dateTag', 'LIKE', "%".$d["date"]."%"]
        ])->get());

      else
        return response()->json(["status" => "failed", "message" => "API syntax error!" ]);
    }

    public function show(Request $request, $id) {
        //var_dump($_POST);
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(Shift::with('sites')->where('user_id', '=', $id)->get());
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

        $res= new Shift($data);
        $status= "failed";

        if($res->save()) {
          $status= "pass";
          if($binds!=null)
            $bindStatus= $res->sites()->sync($binds)? "pass": "failed";
        }
        return response()->json(["status" => $status, "id"=>$res->id, "binds" => $bindStatus]);
    }

    public function update(Request $request, $id) { // PUT/PATCH /route/{id}
        //var_dump($data["binds"]); die("KYS");
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
        
        $res= Shift::find($id);
        $status= "failed";
        $bindStatus= "failed";

        if($res->update($data)) {
          $status= "pass";
          if($binds!=null)
            $bindStatus= $res->sites()->sync($binds)? "pass": "failed";
        }

        return response()->json(["status" => $status, "id"=>$res->id, "binds" => $bindStatus]);
    }

    public function shiftApproval(Request $request, $id) {
        $data= $request->all();

        if(\Validator::make($data, ['isApproved' => 'required',])->fails()? false: true);

        $res= Shift::find($id);

        $status= "failed";

        if(\Auth::user()->type= "Valet" && $res->isApproved=="Yes")
          return response()->json(["status" => $status, "message"=>"Shift is locked."]);
        
        if($res->update($data)) {
          $status= "pass";
        }

        return response()->json(["status" => $status, "id"=>$res->id]);
    }

    public function destroy(Request $request, $id) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(["status" => Shift::find($id)->delete()? "pass": "failed"]);
    }
    /*
    public function bindSite(Request $request, $id){
        return response()->json(["status" => Shift::find($id)->sites()->sync($request->input('binds'))? "pass": "failed"]);
    }*/

    public function create() { }
    public function edit($id) { }
}

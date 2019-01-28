<?php

/*
GET /photos index
GET /photos/create  create 
POST    /photos store
GET /photos/{photo} show
GET /photos/{photo}/edit    edit
PUT/PATCH   /photos/{photo} update
DELETE  /photos/{photo} destroy
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use File;
use Mail;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    public function __construct() {
        $allowedRole= array('SUPER', 'MANAGER', 'VALET', 'CUSTOMEr');
        $this->middleware(['fhkAuth:super,none'], ['allow' => ['ALL'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:manager,api'], ['allow' => ['index', 'show', 'getRole'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:valet,api'], ['allow' => ['index', 'show', 'getRole'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:customer,api'], ['allow' => ['index', 'show', 'getRole'], 'restrict'=>$allowedRole]);
    }

    public function isValid($fields){
        return \Validator::make($fields, [
            'name' => 'required',
            'email' => 'required',
            'type' => 'required',
            'contact' => 'required',
            'wage' => 'required',
            //'password' => 'required',
            //'image' => 'required',
            //'files' => 'mimes:jpeg,bmp,png,jpg',
        ])->fails()? false: true;
    }

    public function index(Request $request) {
      //$this->informUser(User::find(1), "1234567");
      if(!$request->wantsJson())
          return view('user');
      return response()->json(User::all());
    }

    public function getRole(Request $request, $role) {
      //$this->informUser(User::find(1), "1234567");
      if(strtoupper($role) == "ALL")
        return response()->json(User::all());
      else
        return response()->json(User::where("type", $role)->get());
    }

    public function show(Request $request, $id) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(User::find($id));
    }

    protected function informUser($u, $password) {
      //url("img/logo.png");
      Mail::send([], [], function($message) use ($u, $password) {
        $message->subject('Welcome '. $u->name);
        $message->to($u->email, $u->name); //$u->email
        $message->from('delvesol92@gmail.com','EnviroClean');
        
        $body= "<h1>Hi, $u->name </h1><br/>
          You can login to your portal (" . url("") . ") using your email and password ($password). <br/><br/>
          <img style='width: 200px;' src='" . url("img/logo.png") . "'> </img>
          ";
        $message->setBody($body, 'text/html');
      });
    }

    public function store(Request $request) {
        //dd($request->all());
        if(!$this->isValid($request->all()))
            return response()->json(["error" => "Check your arguments."]);

        $res= new User($request->all());
        $password= $res->password!=null? $res->password: "1234567";

        if($res->password!=null)
            $res->password= Hash::make($res->password);
        else
            $res->password= Hash::make("1234567");

        if($res->image==null)
            unset($res->image);

        if($request->hasFile('files')) {
            $file = $request->file('files')[0];
            $unique= md5($file->getClientOriginalName().time()).".".$file->extension();
            $file->move('uploads/userImages', $unique);
            $res->image= 'uploads/userImages/'.$unique;
        }

        if($res->save()) {
          $this->informUser($res, $password);
          return response()->json(["status" => "pass", "id"=>$res->id, "image"=>$res->image]);
        }
        return response()->json(["status" => "failed"]);
        //return response()->json(["status" => $res->save()? "pass": "failed", "image"=>$res->image, "id"=>$res->id]);
    }

    public function update(Request $request, $id) {
        if(!$this->isValid($request->all()))
            return response()->json(["error" => "Check your arguments."]);

        $res= User::find($id);
        $data= $request->all();

        if($data["password"]!=null)
            $data["password"]= Hash::make($data["password"]);
        else
            unset($data["password"]);

        if($data["image"]==null)
            unset($data["image"]);

        if($request->hasFile('files')) {
            $file = $request->file('files')[0];
            $unique= md5($file->getClientOriginalName().time()).".".$file->extension();
            $file->move('uploads/userImages', $unique);
            //if(!$res->image=="img/noPicture.png")
            File::delete('uploads/userImages/'.$res->image);
            $data["image"]= 'uploads/userImages/'.$unique;
        }

        return response()->json(["status" => $res->update($data)? "pass": "failed", "image"=>isset($data["image"])?$data["image"]:null]);
    }

    public function destroy(Request $request, $id) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(["status" => User::find($id)->delete()? "pass": "failed"]);
    }

    public function create() { }
    public function edit($id) { }
}

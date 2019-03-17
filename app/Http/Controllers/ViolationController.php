<?php

namespace App\Http\Controllers;

use App\Violation;
use Illuminate\Http\Request;
use File;

class ViolationController extends Controller {
    public function __construct() {
        $allowedRole= array('SUPER', 'MANAGER', 'VALET', 'CUSTOMEr');
        $this->middleware(['fhkAuth:super,none'], ['allow' => ['ALL'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:manager,api'], ['allow' => ['ALL'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:valet,api'], ['allow' => ['store'], 'restrict'=>$allowedRole]);
        $this->middleware(['fhkAuth:customer,api'], ['allow' => ['index', 'show'], 'restrict'=>$allowedRole]);
    }

    public function isValid($fields){
        return \Validator::make($fields, [
            //'infraction_id' => 'required', not required any more
            'fence_id' => 'required',
            'user_id' => 'required',
            'unitNumber' => 'required',
            'photo_id' => 'required',
        ])->fails()? false: true;
    }

    public function index(Request $request) {
        if(!$request->wantsJson())
            return view('violation');
        return response()->json(Violation::with(['user', 'infraction', 'fence', ])->get()); //::all()
    }

    public function violationbysite(Request $request, $id) {
        if(!$request->wantsJson())
            return view('violation');

        return response()->json(Violation::whereHas('fence', function($q1) use ($id) {
          $q1->whereHas('site', function($q2) use ($id) {
            $q2->where([
              ["sites.id", "=", $id]
            ]);
            // $q2->whereHas('region', function($q3) use ($id) {
            //   $q3->where([
            //     ["regions.id", "=", $id]
            //   ]);
            // });
          });
        })->get());

        //return response()->json(Violation::all());
        /*
        $c = Company::where('active','=',1)->whereHas('user', function($q)
        {
          $q->whereHas('group', function($q)
          {
            $q->whereIn('group.name_short', array('admin','user'));
          });
        })->get();*/
        //$users = DB::select('select * from users where active = ?', [1]);
        /*return response()->json(Violation::where([
          ["site.fence.region.id", "=", $id]
        ])->get());*/
        //with(['fence.site.region'=> function($query) use ($id) {}])
    }

    protected function downloadFormat(){
      $data= Violation::all();

      $data->transform(function($i) {
          unset($i->id);
          unset($i->updated_at);
          $i->image= url('/'.$i->image);
          
          $i->valet= $i->user->name;
          unset($i->user_id);
          unset($i->user);
          $i->fenceName= $i->fence->fenceName;
          unset($i->fence_id);
          unset($i->fence);
          $i->infractioName= $i->infraction->infractionName;
          unset($i->infraction_id);
          unset($i->infraction);
          return $i;
      });
      return $data;
    }

    public function downloadJson(){
      $data= $this->downloadFormat();
      return response()->json($data, 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }

    public function downloadCsv(){
      $data= $this->downloadFormat()->toArray();
      $out = "created_at, image, valet, fenceName, infractionName\r\n";
      foreach($data as $arr) {
        //var_dump($arr); die();
        $out .= implode(', ', $arr) . "\r\n";
      }
      return response($out);
    }

    public function show(Request $request, $id) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(Violation::find($id));
    }

    public function store(Request $request) {

        if(!$this->isValid($request->all()))
            return response()->json(["error" => "Check your arguments."]);

        $res= new Violation($request->all());

        if($res->image==null)
            unset($res->image);
          
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $unique= md5($file->getClientOriginalName().time()).".".$file->extension();
            $file->move('uploads/violationImages', $unique);
            $res->image= 'uploads/violationImages/'.$unique;
        }

        return response()->json(["status" => $res->save()? "pass": "failed"]);
    }

    public function update(Request $request, $id) {
        if(!$this->isValid($request->all()))
            return response()->json(["error" => "Check your arguments."]);

        $res= Violation::find($id);
        $data= $request->all();
        
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $unique= md5($file->getClientOriginalName().time()).".".$file->extension();
            $file->move('uploads/violationImages', $unique);
            File::delete('uploads/violationImages/'.$res->image);
            $data["image"]= 'uploads/violationImages/' . $unique;
        }

        return response()->json(["status" => $res->update($data)? "pass": "failed"]);
    }

    public function destroy(Request $request, $id) {
        if(!$request->wantsJson())
            return response()->json(["error" => "Web interface not supported."]);
        return response()->json(["status" => Violation::find($id)->delete()? "pass": "failed"]);
    }

    public function create() { }
    public function edit($id) { }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class FhkAuthorization { //or fhkAuth
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    function throwView($request, $message, $redirect='/'){
      if($request->wantsJson()) {
        return response()->json(["err"=> $message]);
      } else {
        Session::flash('FhkAuthorization', $message); 
        return redirect($redirect);
      }
    }
    public function handle($request, Closure $next, $role, $interface) {

        //check authentication
        $user= \Auth::user();
        if($user==null)
          return $this->throwView($request, "Authentication error!");

        $filteredRole= strtoupper($user->type);
        $guardRole= strtoupper($role);
        $requestApi = $request->route()->getActionMethod();

        //get options for current middleware
        $options= null;
        $midWares= $request->route()->getController()->getMiddleware();
        foreach ($midWares as $key => $value) {
            if($value["middleware"]=== "fhkAuth:".$role.",".$interface)
                $options= $value["options"];
        }

        //var_dump($request->route()->getController()->getMiddleware()); die();
        //check if given role is within valid roles, DEV ONLY FOR TYPOS
        $roles = array_map('strtoupper', $options["restrict"]);
        if(!in_array($guardRole, $roles))
          return $this->throwView($request, "Not a valid role $guardRole in controller.");
        
        //if role does not match current then just continue
        if($filteredRole!= strtoupper($role))
            return $next($request);    

        //get allowed routes and check against currrent route
        if(!in_array($requestApi, $options["allow"]) && !in_array("ALL", $options["allow"]))
          return $this->throwView($request, "Permission Error");

        if(strtoupper($interface)=='API' && !$request->wantsJson())
          return $this->throwView($request, "Web portal restriction!");

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TercerosUserLoginRequest;

class TercerosUserController extends Controller
{
    
    public function login ( TercerosUserLoginRequest $FormData ){
        
        if ( Auth::attempt($request->only('email', 'password') )) {
            return response()->json( Auth::user(), 200);
        } 
        
        throw ValidationException::withMessages( [
            'email' =>  [ Lang::get("validation.attributes.login-error") ]
        ]);

    }

}

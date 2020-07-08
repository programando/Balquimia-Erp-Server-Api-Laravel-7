<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register( Request $request ) {
        $request->validate( [
             'name'      => ['required'],
             'email'     => ['required', 'email', 'unique:users'],
             'password'  => ['required', 'min:2', 'confirmed']
        ]);

        User::create ( [
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make( $request->password)
        ]);

    }

    public function login( Request $request ) {
         $request->validate( [
             'email'     => ['required' ],
             'password'  => ['required' ]
        ]);      
 
        if ( Auth::attempt($request->only('email', 'password') )) {
            return response()->json( Auth::user(), 200);
        }    


        throw ValidationException::withMessages( [
            'email' =>  [ Lang::get("validation.attributes.login-error") ]
        ]);

    }

    public function logout(){
        Auth::logout();
    }


}

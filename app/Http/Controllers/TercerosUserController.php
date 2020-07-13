<?php

namespace App\Http\Controllers;

use Str;
use Cache;

use Session;
use Carbon\Carbon;
use App\Models\TercerosUser;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Events\UserPasswordResetEvent;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\TercerosUserLoginRequest;

class TercerosUserController extends Controller
{
    
    public function login ( TercerosUserLoginRequest $FormData ){
        
        /* if ( Auth::attempt($FormData->only('email', 'password', 'autorizado') )) { */
         if (Auth::attempt( [
                  'email'    => $FormData->email,
                  'password' => $FormData->password,
                  'autorizado' => 1 ],
                   true ) ) {                               // true al final es para recordar sessión               
            return response()->json( Auth::user(), 200);
        }    
        $this->ErrorMessage ( Lang::get("validation.custom.UserLogin.credencials-error") );
    }
  
    public function resetPassword ( TercerosUserLoginRequest $FormData ){
        $User = TercerosUser::where('email', $FormData->email)->first();
        if ( ! $User->autorizado || $User->inactivo ) {
            $this->ErrorMessage (  Lang::get("validation.custom.UserLogin.inactive-user") );
        }
        
        $User->tmp_token        = Str::random(100);
        $User->tmp_token_expira = Carbon::now()->addMinute(10) ;
        $User->save();
        $DataUser = [
            'user' => $User->email,
            'token' => $User->tmp_token,
        ];
        UserPasswordResetEvent::dispatch( compact('DataUser'));

        return response()->json($User, 200);  
 
    }


    public function logout(){
        Session::flush();
        Cache::flush();
        Auth::logout();
    }


    private function ErrorMessage ( $ErrorTex ) {
        throw ValidationException::withMessages( [
            'email' =>  [$ErrorTex  ]
        ]);
    }

}

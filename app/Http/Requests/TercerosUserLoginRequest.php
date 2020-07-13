<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class TercerosUserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
         $currentRouteName = Route::currentRouteName();
        if ( $currentRouteName == 'login')              {  return $this->Loginvalidate();       }
        if ( $currentRouteName == 'reset-password')     {  return $this->ResetPassword();    }
    }

     private function Loginvalidate(){
          return [
                'email'       => ['required', 'email','exists:terceros_users'],
                'password'    => ['required'],
        ];
    }

 /*    return [
      'slug'=> ['required', 'unique:slugs, camposlug,'. $this->slug]
      ] */

    private function ResetPassword(){
          return [
                'email'       => ['required', 'email','exists:terceros_users'],
        ];
    }


    public function messages()
    {
      return [
        'email.exists' => 'Cuenta de correo (Email) no encontrada en nuestros registros',
      ];
    }

}

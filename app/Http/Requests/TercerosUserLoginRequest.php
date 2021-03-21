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
        if ( $currentRouteName == 'login')              {  return $this->loginvalidate();       }
        if ( $currentRouteName == 'reset-password')     {  return $this->resetPassword();       }
        if ( $currentRouteName == 'update-password')    {  return $this->updatePassword();      }

        
    }

     private function loginvalidate(){
          return [
                'email'       => ['required', 'email','exists:terceros_users'],
                'password'    => ['required','min:6'],
        ];
    }

     /*    return [
      'slug'=> ['required', 'unique:slugs, camposlug,'. $this->slug]
      ] */

      private function resetPassword(){
            return [
                  'email'  => ['required', 'email','exists:terceros_users'],
          ];
      }

    private function updatePassword() {
          return [
                  'password'  => ['required','confirmed','min:7'],
          ];
    }

    public function messages()
    {
      return [
        'email.exists' => 'Cuenta de correo (Email) no encontrada en nuestros registros',
        'password.confirmed' => 'La contraseña y su confirmación no son iguales.',
        'password.required' => 'La contraseña y su confirmación son campos obligatorios',
        'password.min' => 'La contraseña debe tener al menos 7 caracteres',
      ];
    }

}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public $validator = null;

    public function authorize()
    {
        return true;
    }

    public function validator($factory)
    {
        return $factory->make(
            $this->sanitize(), $this->container->call([$this, 'rules']), $this->messages()
        );
    }

    public function sanitize()
    {
        $this->merge([
            'json' => json_decode($this->input('json'), true)
        ]);
        return $this->all();
    }

    public function messages()
    {
        return [ 
            'json.email.required'       => 'El campo del Correo Eletrónico es obligatorio.',
            'json.email.email'          => 'El campo del correo electrónico debe ser una dirección válida.' ,
            'json.email.unique'         => 'El Correo Eletrónico ya existe, intenté con otro.' ,
            'json.password.required'    => 'El campo de la contraseña es obligatoria.',
            'json.password.min'         => 'El campo de la contraseña debe tener al menos 6 caracteres.',
            // 'json.password.confirmed'   => 'La confirmación de la contraseña no coincide.',   
            'json.lastname.required'    => 'Apellido Materno Requerido',
            // 'json.photo.required'       => 'El campo de la foto es obligatorio.',
        ];
    }
     
    public function rules()
    {  
        return [
            'json.email'            => 'required|email|unique:users,email',
            'json.password'         => 'required|min:4',
            // 'json.password'         => 'required|confirmed|min:4',
            // "password_confirmation" => "min:6",
            'json.name'             => 'required',
            // 'json.surname'          => 'required',
            'json.lastname'         => 'required', 
            // 'json.photo'            => 'required', 
        ]; 
    }
     
    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }
}

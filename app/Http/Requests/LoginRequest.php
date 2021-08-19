<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'json.email.email'          => 'El campo del correo electrónico debe ser una dirección válida.', 
            'json.password.required'    => 'El campo de la contraseña es obligatoria.', 
        ];
    }
     
    public function rules()
    {  
        return [
            'json.email'            => 'required|email',
            'json.password'         => 'required|min:4' 
        ]; 
    }
     
    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }
}

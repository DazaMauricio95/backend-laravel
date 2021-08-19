<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalsRequest extends FormRequest
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
        $params_array = json_decode($this->input('json'), true);    //Obtengo en array
        if(!empty($params_array)){ 
            $params_array = array_map('trim', $params_array);   //Limpiar los espacios 
        } 
        $this->merge([
            'json' => $params_array
        ]);
        return $this->all();
    }

    public function messages()
    {
        return [  
            "required"                      => 'Es requerido',
            "json.Fkidbook.required"        => 'El libro es requerido', 
            "json.Fkiduser.required"        => 'El usuario es requerido', 
            "json.rentDate.required"        => 'La fecha de renta es requerido', 
            "json.returnDate.required"      => 'La fecha devolución es requerida', 
            "json.statusRent.required"      => 'El estado de la renta es requerida',
            "json.name.required"      => 'El nombre del usuario es requerido',
            "json.lastname.required"      => 'El apellido del usuario es requerido' 
        ];
    }
     
    public function rules()
    {  
         
        switch ($this->method()) {
            case 'POST':
                return [ 
                    "json.Fkidbook"     => 'required', 
                    // "json.Fkiduser"      => 'required', 
                    "json.rentDate"     => 'required', 
                    "json.returnDate"   => 'required',  
                    'json.name'         => 'required',
                    'json.lastname'     => 'required',
                ]; 
                break;
            case 'PUT':
                return [ 
                    "json.Fkidbook"      => 'required', 
                    "json.Fkiduser"      => 'required', 
                    "json.rentDate"      => 'required', 
                    "json.returnDate"    => 'required', 
                    "json.statusRent"    => 'required', 
                ]; 
            default: break;
        }
    }
     
    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }
}

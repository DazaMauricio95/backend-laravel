<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
            "json.nameCategory.required"            => "El nombre de la categoría es requerida", 
            "json.description.required"             => "La descripción es requerida",  
        ];
    }
     
    public function rules()
    {  
        switch ($this->method()) {
            case 'POST':
                return [  
                    "json.nameCategory"          => "required", 
                    "json.description"            => "required"
                ];
                break;
            case 'PUT':
                return [ 
                    "json.nameCategory"          => "required", 
                    "json.description"            => "required"
                ]; 
            default: break;
        } 
    }
     
    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }
}

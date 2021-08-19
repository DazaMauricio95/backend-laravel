<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BooksRequest extends FormRequest
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
            "json.nameBook.required"            => "El nombre del libro es requerido", 
            "json.author.required"              => "El nombre del autor es requerido", 
            "json.publicationDate.required"     => "La fecha de publicación es requerido", 
            "json.Fkidcategory.required"        => "La categoría es requerida",
            "json.Fkidcreador.required"         => "El creador es requerido"
        ];
    }
     
    public function rules()
    {  
        switch ($this->method()) {
            case 'POST':
                return [ 
                    "json.nameBook"          => "required", 
                    "json.author"            => "required", 
                    "json.publicationDate"   => "required", 
                    "json.Fkidcategory"      => "required",
                    'json.Fkidcreador'       => "required" 
                ];
                break;
            case 'PUT':
                return [ 
                    "json.nameBook"          => "required", 
                    "json.author"            => "required", 
                    "json.publicationDate"   => "required", 
                    "json.Fkidcategory"      => "required"  
                ]; 
            default: break;
        } 
    }
     
    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }
}

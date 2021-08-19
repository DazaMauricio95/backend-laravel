<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;
    protected $table = 'categories';
    // public $timestamps = false;
    protected $primaryKey 	= 'IdCategory';
    protected $fillable 	= [ 'nameCategory','description'];
    public function books(){
        return $this->hasMany('App\Models\books','Fkidcategory','IdCategory');
    }
}

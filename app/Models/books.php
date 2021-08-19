<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class books extends Model
{
    use HasFactory;
    protected $table = 'books'; 
    protected $primaryKey 	= 'IdBook';
    protected $fillable 	= [ 'nameBook','author','publicationDate','Fkidcategory','Fkidcreador'];

    public function categories(){
        return $this->hasOne('App\Models\categories','IdCategory','Fkidcategory'); 
    }

    public function creator(){
        return $this->hasOne('App\Models\User','id','Fkidcreador'); 
    }

    public function rentals(){
        return $this->hasMany('App\Models\rentals','Fkidbook','IdBook');
    }
}

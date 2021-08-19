<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rentals extends Model
{ 
    use HasFactory;
    protected $table = 'rentals';
    // public $timestamps = false;
    protected $primaryKey 	= 'IdRent';
    protected $fillable 	= [ 'Fkidbook','Fkiduser','rentDate','returnDate'];

    public function book(){
        // return $this->hasMany('App\Models\books','Fkidbook','IdBook');
        return $this->hasOne('App\Models\books','IdBook','Fkidbook');
    }

    public function user(){
        // return $this->hasMany('App\Models\User','Fkiduser','id');
        return $this->hasOne('App\Models\User','id','Fkiduser');
    }
}

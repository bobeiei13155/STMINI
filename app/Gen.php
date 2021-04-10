<?php

namespace App;
use App\Carmodel;
use Illuminate\Database\Eloquent\Model;

class Gen extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'Id_Gen';

    // public function Carmodel()
    // {
    //     return $this->hasMany(Carmodel::class);
    // }
    
}

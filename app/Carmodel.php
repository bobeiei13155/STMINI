<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\gen;
class Carmodel extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'Id_Carmodel';

    // public function gen()
    // {
    //     return $this->belongsTo(gen::class);
    // }


}

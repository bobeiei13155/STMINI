<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telemp extends Model
{   
    public $incrementing = false;
    protected $primaryKey = 'Id_Emp';
    protected $fillable = ['Id_Emp','Tel_Emp'];
    public function employee()
    {
        return $this->belongsTo(Telemp::class);
    }
 
}

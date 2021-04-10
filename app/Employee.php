<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'Id_Emp';

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function telemp()
    {
        return $this->hasMany(Telemp::class);
    }
}

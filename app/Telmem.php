<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telmem extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'Id_Member';
    protected $fillable = ['Id_Member','Tel_MEM'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telptn extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'Id_Partner';
    protected $fillable = ['Id_Partner','Tel_PTN','Address_Partner'];

}

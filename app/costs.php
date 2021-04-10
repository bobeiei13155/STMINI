<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class costs extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'Id_Partner';
    protected $fillable = ['Id_Partner','Cost','Id_Product'];
}

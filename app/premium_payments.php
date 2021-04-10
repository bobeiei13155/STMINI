<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class premium_payments extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'Id_Promotion';
    protected $fillable = ['Id_Premium_Pro','Id_Promotion','quantity'];

    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class promotion_payments extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'Id_Promotion';
    protected $fillable = ['Id_Promotion','Id_Premium_Pro','Amount_Premium_Pro'];
}

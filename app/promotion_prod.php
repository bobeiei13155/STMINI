<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class promotion_prod extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'Id_Promotion';
    protected $fillable = ['Id_Promotion','Id_Premium_Pro','Id_Product','Amount_Premium_Pro','No_Promotion'];
}

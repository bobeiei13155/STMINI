<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PremiumPro extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'Id_Premium_Pro';
    protected $fillable = ['Id_Premium_Pro','Name_Premium_Pro','Img_Premium_Pro','Amount_Premium_Pro'];
}

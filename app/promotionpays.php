<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class promotionpays extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'Id_Promotion';
    protected $fillable = ['Id_Promotion','Name_Promotion','Sdate_Promotion','Edate_Promotion','Payment_Amount'];
}

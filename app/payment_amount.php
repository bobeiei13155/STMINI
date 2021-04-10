<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payment_amount extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'Id_Promotion';
    protected $fillable = ['Id_Promotion','Name_Promotion','Payment_Amount','Sdate_Promotion','Edate_Promotion'];

}

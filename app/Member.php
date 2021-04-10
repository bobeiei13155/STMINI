<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'Id_Member';
}

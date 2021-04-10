<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Employees', function (Blueprint $table) {
            $table->bigIncrements('Id_Emp');
            $table->string('Title_Emp');
            $table->string('FName_Emp');
            $table->string('LName_Emp');
            $table->string('Email_Emp')->unique();
            $table->string('Username_Emp');
            $table->string('Password_Emp');
            $table->string('Idcard_Emp');
            $table->integer('Salary_Emp'); 
            $table->text('Address');
            $table->date('Bdate_Emp');
            $table->char('Tel_Emp', 10);
            $table->integer('Position_Id'); 
            $table->integer('Subdistrict_Id'); 
            $table->rememberToken();
            $table->timestamps();    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}

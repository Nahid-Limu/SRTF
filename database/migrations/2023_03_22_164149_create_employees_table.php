<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('employee_name',100)->nullable();
            $table->string('employee_code',100)->nullable()->index();
            $table->string('employee_phone')->nullable();
            $table->integer('designation_id')->nullable()->index();
            $table->integer('shift_id')->nullable()->index();
            $table->tinyInteger('status')->comment('"1" is enable or  "0" disable')->default(0);
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

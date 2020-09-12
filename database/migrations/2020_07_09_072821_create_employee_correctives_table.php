<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeCorrectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_correctives', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('employee_id');
            $table->integer('admin_id');
            $table->integer('corrective_level_id');
            $table->text('facts')->nullable();
            $table->text('explanation')->nullable();
            $table->text('action_taken')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('employee_correctives');
    }
}

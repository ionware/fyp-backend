<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('firstName');
            $table->string('lastName');
            $table->enum('gender', ['M', 'F'])->default('M');
            $table->string('email')->unique();
            $table->string('matricNo')->unique();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('session_id')->constrained('sessions');
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
        Schema::dropIfExists('students');
    }
}

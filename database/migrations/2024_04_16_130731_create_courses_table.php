<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('cname');
            $table->string('cdesc');
            $table->string('cleng');
 
            $table->unsignedBigInteger('tid');
            $table->foreign('tid')->references('id')->on('teachers')->onDelete('cascade');
            $table->string('ctime');
            $table->float('camount');
            $table->string('cstart');
            $table->string('cend');
            $table->string('cseat');
            $table->string('image')->nullable();


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
        Schema::dropIfExists('courses');
    }
};

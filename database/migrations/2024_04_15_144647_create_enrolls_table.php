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
        Schema::create('enrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uid');
            $table->unsignedBigInteger('cid');
            // $table->unsignedBigInteger('tid');
            // $table->foreign('uid')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('cid')->references('id')->on('courses')->onDelete('cascade');

            // $table->string('uname');
            // $table->string('uemail');
            // $table->string('cname');
            // $table->string('cteach');
            // $table->string('cleng');
            // $table->string('camount');
            

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
        Schema::dropIfExists('enrolls');
    }
};

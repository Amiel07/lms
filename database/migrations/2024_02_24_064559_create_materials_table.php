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
        Schema::create('materials', function (Blueprint $table) {
            // type 1 = file
            // type 2 = link
            // type 3 = yt video
            $table->id();
            $table->string('name');
            $table->integer('type');
            $table->string('resource')->nullable();
            $table->string('link')->default('')->nullable();
            $table->integer('hidden');
            $table->unsignedBigInteger('module_id'); 
            $table->timestamps();

            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
};

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
        Schema::table('users', function (Blueprint $table) {
           $table->string('contact')->nullable();
           $table->text('address')->nullable();
           $table->string('pincode',6)->nullable();
           $table->boolean('status')->comment('1:Actice and 2:Inactive')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->string('contact')->nullable();
           $table->text('address')->nullable();
           $table->string('pincode',6)->nullable();
           $table->boolean('status')->comment('1:Actice and 2:Inactive')->default(1);
        });
    }
};

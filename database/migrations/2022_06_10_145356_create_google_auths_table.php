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
        Schema::create('google_auths', function (Blueprint $table) {
            $table->timestamps();
            $table->string('actual_token');
            $table->bigInteger('token_expire_date');
            $table->string('refresh_token');      
            $table->string('email')->primary();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('google_auths');
    }
};

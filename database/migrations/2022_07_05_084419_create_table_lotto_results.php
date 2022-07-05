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
        Schema::create('lotto_results', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('number');
            $table->unique(['date', 'number']);
            $table->index(['date', 'number']);
            $table->timestamp('created_at')->default('now()');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lotto_results');
    }
};

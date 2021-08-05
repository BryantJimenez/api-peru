<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRucsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rucs', function (Blueprint $table) {
            $table->id();
            $table->string('ruc')->unique();
            $table->text('name')->nullable();
            $table->text('state')->nullable();
            $table->text('condition_')->nullable();
            $table->text('ubigeo')->nullable();
            $table->text('type_way')->nullable();
            $table->text('name_way')->nullable();
            $table->text('zone_code')->nullable();
            $table->text('type_zone')->nullable();
            $table->text('number')->nullable();
            $table->text('inside')->nullable();
            $table->text('lot')->nullable();
            $table->text('department')->nullable();
            $table->text('block')->nullable();
            $table->text('km')->nullable();
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
        Schema::dropIfExists('rucs');
    }
}

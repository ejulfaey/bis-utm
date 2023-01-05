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
        Schema::create('calculators', function (Blueprint $table) {
            $table->id();
            $table->decimal('e_energy_of_cosumption');
            $table->integer('e_duration_of_consumption');
            $table->decimal('e_tariff');
            $table->decimal('w_usage_of_water');
            $table->decimal('w_no_of_occupants');
            $table->decimal('w_tariff');
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
        Schema::dropIfExists('calculators');
    }
};

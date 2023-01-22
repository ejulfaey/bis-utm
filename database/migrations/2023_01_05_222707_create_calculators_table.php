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
            $table->decimal('e_energy_of_consumption')->default(0);
            $table->integer('e_duration_of_consumption')->default(0);
            $table->decimal('e_tariff')->default(0);
            $table->decimal('w_usage_of_water')->default(0);
            $table->decimal('w_no_of_occupants')->default(0);
            $table->decimal('w_tariff')->default(0);
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

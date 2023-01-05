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
        Schema::create('construction_costs', function (Blueprint $table) {
            $table->id();
            $table->decimal('area_of_building')->comment('m2');
            $table->integer('building_type_id');
            $table->decimal('construction_cost')->comment('rm/m2');
            $table->decimal('mechanical_cost')->comment('rm/m2');
            $table->decimal('electrical_cost')->comment('rm/m2');
            $table->decimal('hydraulic_cost')->comment('rm/m2');
            $table->decimal('fire_service_cost')->comment('rm/m2');
            $table->decimal('lift_cost')->comment('rm/m2');
            $table->decimal('total_cost')->comment('rm/m2');
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
        Schema::dropIfExists('construction_costs');
    }
};

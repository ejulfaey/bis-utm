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
            $table->decimal('area_of_building')->default(0)->comment('m2');
            $table->integer('building_type_id');
            $table->decimal('construction_cost')->default(0)->comment('rm/m2');
            $table->decimal('mechanical_cost')->default(0)->comment('rm/m2');
            $table->decimal('electrical_cost')->default(0)->comment('rm/m2');
            $table->decimal('hydraulic_cost')->default(0)->comment('rm/m2');
            $table->decimal('fire_service_cost')->default(0)->comment('rm/m2');
            $table->decimal('lift_cost')->default(0)->comment('rm/m2');
            $table->decimal('total_cost')->default(0)->comment('rm/m2');
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

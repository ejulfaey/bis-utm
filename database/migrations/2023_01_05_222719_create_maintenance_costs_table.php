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
        Schema::create('maintenance_costs', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->decimal('no');
            $table->integer('location_id');
            $table->integer('subcomponent_id');
            $table->decimal('area', 14, 2);
            $table->decimal('cost', 14, 2);
            $table->integer('no_of_unit');
            $table->decimal('total_cost', 14, 2);
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
        Schema::dropIfExists('maintenance_costs');
    }
};

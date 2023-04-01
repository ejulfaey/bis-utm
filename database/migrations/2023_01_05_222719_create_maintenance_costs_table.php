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
            $table->decimal(14, 2, 'area');
            $table->decimal(14, 2, 'cost');
            $table->integer('no_of_unit');
            $table->decimal(14, 2, 'total_cost');
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

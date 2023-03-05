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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id');
            $table->decimal('structural_score')->default(0);
            $table->decimal('structural_percent')->default(0);
            $table->decimal('architectural_score')->default(0);
            $table->decimal('architectural_percent')->default(0);
            $table->decimal('building_score')->default(0);
            $table->decimal('building_percent')->default(0);
            $table->decimal('bca_score')->default(0);
            $table->foreignId('classification_id');
            // 
            $table->decimal('initial_cost', 14, 2)->default(0);
            $table->decimal('maintenance_cost', 14, 2)->default(0);
            $table->decimal('time_period', 14, 2)->default(0);
            $table->decimal('discount_rate', 14, 2)->default(0);
            $table->decimal('npv_maintenance', 14, 2)->default(0);
            $table->decimal('energy_usage', 14, 2)->default(0);
            $table->decimal('water_usage', 14, 2)->default(0);
            $table->decimal('rental_cost', 14, 2)->default(0);
            $table->decimal('lcca', 14, 2)->default(0);
            $table->text('summary')->nullable();
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
        Schema::dropIfExists('reports');
    }
};

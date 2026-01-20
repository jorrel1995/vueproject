<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('developments', function (Blueprint $table) {
            $table->id();
            $table->string('plot_number')->nullable();
            $table->integer('housetype')->nullable();
            $table->integer('development')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('status', ['available', 'sold', 'reserved', 'released'])->default('available');
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('developments');
    }
};

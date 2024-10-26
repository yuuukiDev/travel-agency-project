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
        Schema::create('tours', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("travel_id")->nullable()->constrained('travels')->cascadeOnDelete();
            $table->string("name")->nullable();
            $table->date("starting_date")->nullable();
            $table->date("ending_date")->nullable();
            $table->decimal("price", 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};

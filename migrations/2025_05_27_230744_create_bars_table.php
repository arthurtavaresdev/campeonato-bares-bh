<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bars', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name')->comment('Nome do bar');
            $table->string('place_id')->unique()->nullable()->comment('ID do local no Google Places');
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->decimal('rating', 3, 2)->default(0.00)->comment('Avaliação do bar');
            $table->unsignedInteger('reviews')->default(0)->comment('Número de avaliações do bar');
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bars');
    }
};

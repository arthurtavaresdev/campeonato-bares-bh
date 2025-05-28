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
        Schema::create('bar_rankings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('bar_id')->references('id')->on('bars')->onDelete('cascade');
            $table->unsignedInteger('position');
            $table->decimal('score', 6, 4)->default(0.0000);
            $table->date('snapshot_date')->useCurrent();
            $table->char('division', 1)->default('A');
            $table->unsignedTinyInteger('strikes')->default(0)->comment('Número de ausências do bar no top 20');
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bars_rankings');
    }
};

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
        Schema::create('skyll_vacancy', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacancy_id')->references('id')->on('vacancies')->onDelete('cascade');
            $table->foreignId('skyll_id')->references('id')->on('skylls')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skyll_vacancy');
    }
};

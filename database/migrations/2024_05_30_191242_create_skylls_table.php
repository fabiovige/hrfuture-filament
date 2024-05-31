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
        Schema::create('skylls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('occupation_id');
            $table->string('type', 255)->index();
            $table->string('description', 255)->index();
            $table->timestamps();

            $table->foreign('occupation_id')->references('id')->on('occupations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skylls');
    }
};

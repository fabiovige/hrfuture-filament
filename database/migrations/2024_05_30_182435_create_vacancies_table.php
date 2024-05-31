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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            //dados da vaga
            $table->unsignedBigInteger('occupation_id');
            $table->integer('work_regime_id')->nullable();
            $table->integer('work_model_id')->nullable();
            $table->string('work_start_time')->nullable();
            $table->string('work_end_time')->nullable();
            $table->decimal('salary', 9, 2)->nullable();
            $table->boolean('has_benefits')->default(false);
            $table->text('extra_information')->nullable();
            //preferencias
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->integer('education_id')->nullable();
            $table->integer('ethnicity_id')->nullable();
            $table->boolean('has_experience')->default(false);
            $table->integer('experience_id')->default(false);
            $table->boolean('has_disability')->default(false);
            $table->boolean('has_travel')->default(false);
            $table->boolean('has_language')->default(false);
            //empregador
            $table->string('company')->nullable();
            $table->string('responsible_person')->nullable();
            $table->text('about')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('address')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->timestamps();


            $table->foreign('occupation_id')->references('id')->on('occupations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};

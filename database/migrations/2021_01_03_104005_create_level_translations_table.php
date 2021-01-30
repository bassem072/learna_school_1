<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_system_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('education_system_id');
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['education_system_id', 'locale']);
            $table->foreign('education_system_id')->references('id')->on('education_systems')->onDelete('cascade');
        });

        Schema::create('stage_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stage_id');
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['stage_id', 'locale']);
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade');
        });

        Schema::create('year_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id');
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['year_id', 'locale']);
            $table->foreign('year_id')->references('id')->on('years')->onDelete('cascade');
        });

        Schema::create('section_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id');
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['section_id', 'locale']);
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('level_translations');
    }
}

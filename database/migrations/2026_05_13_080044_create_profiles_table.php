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
        Schema::create('profiles', function (Blueprint $table) {
           $table->id();
            $table->string('name');
            $table->string('role');
            $table->text('bio');
            $table->text('education');
            $table->text('objective');
            $table->string('avatar')->nullable();
            $table->string('cv_path')->nullable();
            $table->boolean('is_available')->default(true);
            $table->integer('stats_experience')->default(0);
            $table->integer('stats_projects')->default(0);
            $table->integer('stats_internships')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};

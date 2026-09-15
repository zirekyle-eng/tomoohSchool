<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('teacher_applications')) {
            return;
        }

        Schema::create('teacher_applications', function (Blueprint $table): void {
            $table->id();
            $table->string('full_name', 160);
            $table->string('phone', 30);
            $table->string('email', 160)->nullable();
            $table->string('specialization', 180);
            $table->text('qualifications');
            $table->unsignedTinyInteger('years_experience')->nullable();
            $table->text('bio')->nullable();
            $table->string('verification_source', 500)->nullable();
            $table->string('status', 30)->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_applications');
    }
};

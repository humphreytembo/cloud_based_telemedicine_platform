<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultation_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');

            // Vitals
            $table->string('blood_pressure')->nullable();
            $table->string('temperature')->nullable();
            $table->string('weight')->nullable();
            $table->string('heart_rate')->nullable();

            // Medical
            $table->text('diagnosis');
            $table->text('prescription')->nullable();
            $table->text('notes')->nullable();

            // Follow up
            $table->date('follow_up_date')->nullable();
            $table->string('follow_up_instructions')->nullable();

            // Status
            $table->enum('status', ['draft', 'published'])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultation_reports');
    }
};
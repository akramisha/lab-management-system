<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            // Link to the patient who created the appointment
            $table->foreignId('patient_id')->constrained('registers')->onDelete('cascade'); 
            
            $table->string('test_type'); // e.g., 'Blood Test', 'COVID Test', etc.
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->text('notes')->nullable();
            
            // Status of the appointment (new is the default)
            $table->enum('status', ['new', 'approved', 'rejected', 'cancelled', 'sample_received', 'report_uploaded'])
                  ->default('new');
            
            // Link to the employee assigned by the Admin (nullable)
            $table->foreignId('assigned_employee_id')->nullable()->constrained('registers');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
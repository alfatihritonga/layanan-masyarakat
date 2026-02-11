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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->foreignId('relawan_id')->constrained('relawan')->onDelete('cascade');
            $table->foreignId('assigned_by')->constrained('users')->onDelete('cascade');
            
            $table->enum('status', ['assigned', 'on_the_way', 'on_site', 'completed', 'cancelled'])->default('assigned');
            $table->text('notes')->nullable();
            
            $table->timestamp('assigned_at');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('completion_notes')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('report_id');
            $table->index('relawan_id');
            $table->index('status');
            
            // Unique constraint
            $table->unique(['report_id', 'relawan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};

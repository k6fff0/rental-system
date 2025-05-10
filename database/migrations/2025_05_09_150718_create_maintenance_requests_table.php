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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');
            $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('set null');
            $table->string('type');
            $table->text('description');
            $table->string('image')->nullable();
            $table->enum('status', ['new', 'in_progress', 'completed', 'rejected'])->default('new');
            $table->foreignId('assigned_worker_id')->nullable()->constrained('maintenance_workers')->onDelete('set null');
            $table->text('start_notes')->nullable();
            $table->text('note')->nullable(); // ✅ ملاحظات عامة
            $table->text('end_notes')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};

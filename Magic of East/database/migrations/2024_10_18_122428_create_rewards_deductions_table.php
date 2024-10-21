<?php

use App\Enums\EmployerExpenseType;
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
        Schema::create('rewards_deductions', function (Blueprint $table) {
            $table->id();
            // $table->enum('type' , [EmployerExpenseType::reward, EmployerExpenseType::deduction]);
            $table->enum('type', array_column(EmployerExpenseType::cases(), 'value'));
            $table->integer('amount');
            $table->foreignId('employer_id')->constrained('employees')->cascadeOnDelete();  
            $table->timestamps();
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards_deductions');
    }
};
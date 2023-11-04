<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('perpetrator_id');
            $table->integer('reporter_id');
            $table->dateTime('submitted_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('handled_time')->nullable();
            $table->integer('handling_admin_id')->nullable();
            $table->enum('report_status', ['New', 'Accepted', 'Declined'])->default('New');
            $table->longText('reporter_comment')->nullable();
            $table->longText('admin_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};

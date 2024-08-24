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
        Schema::create('leave_request_teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leave_request_id')->nullable()->constrained('leave_requests');
            $table->string('idteacher', 50)->nullable()->comment('identificador del maestro');
            $table->string('idnotificacion', 50)->nullable()->comment('identificador del maestro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_request_teachers', function (Blueprint $table) {
            $table->dropForeign(['leave_request_id']);
            $table->dropColumn('leave_request_id');
        });
        Schema::dropIfExists('leave_request_teachers');
    }
};

<?php

use App\Enums\Kinship;
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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('idestudiante', 100)->nullable()->comment('identificador del estudiante');
            $table->string('requester_name')->nullable()->comment('nombre del solicitante');
            $table->string('ci', 100)->nullable()->comment('carnet de identidad');
            $table->string('reason', 1000)->nullable()->comment('motivo');
            $table->enum('kinship', Kinship::toArrayValues())->nullable()->comment('parentesco');
            $table->timestamp('end_date')->nullable()->comment('fecha final');
            $table->timestamp('start_date')->nullable()->comment('fecha inicial');
            $table->string('nombre', 100)->nullable()->comment('nombre del estudiante');
            $table->string('idcurso', 100)->nullable()->comment('identificador del curso');
            $table->string('codestudiante', 100)->nullable()->comment('código del estudiante');
            $table->string('curso', 100)->nullable()->comment('curso del estudiante');
            $table->foreignId('notification_id')->nullable()->comment('notificacion id del tipo notificacion a estudiante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};

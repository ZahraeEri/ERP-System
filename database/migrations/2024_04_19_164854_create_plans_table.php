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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('ingenieur_tecnitas');
            $table->string('mod');
            $table->string('accuse_entree');
            $table->date('date_transmission');
            $table->string('architecte');
            $table->string('projet');
            $table->string('np');
            $table->string('bet');
            $table->string('accuse_sortie');
            $table->text('observation')->nullable();
            $table->string('entreprise');
            $table->string('expediteur');
            $table->string('numero_ex');
            $table->string('etat_de_plan');
            $table->string('etat_de_transmission');
            $table->string('coordinateur');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

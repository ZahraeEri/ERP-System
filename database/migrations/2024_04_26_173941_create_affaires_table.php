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
        Schema::create('affaires', function (Blueprint $table) {
                $table->id();
                $table->string('Numero');
                $table->string('Denomination');
                $table->decimal('Montant_Controle_plans_TTC', 8, 2);
                $table->decimal('Montant_Controle_travaux_TTC', 8, 2);
                $table->decimal('Montant_RC_TTC', 8, 2);
                $table->decimal('Montant_HT', 8, 2);
                $table->string('Type_de_lot');
                $table->decimal('Retenue_de_garantie', 8, 2);
                $table->decimal('Montant_Controle_plans_HT', 8, 2);
                $table->decimal('Montant_Controle_travaux_HT', 8, 2);
                $table->decimal('Montant_RC_HT', 8, 2);
                $table->decimal('TVA', 8, 2);
                $table->decimal('Montant_TVA', 8, 2);
                $table->decimal('Montant_RC_TVA', 8, 2);
                $table->decimal('Montant_TTC', 8, 2);
                $table->string('Mis_a_jour_par');
                $table->decimal('Montant_Controle_plans_TVA', 8, 2);
                $table->decimal('Montant_Controle_travaux_TVA', 8, 2);
                $table->string('Client');
                $table->string('Tel_client');
                $table->string('Adresse_chantier');
                $table->string('Maitre_doeuvre');
                $table->string('Fax');
                $table->string('BET');
                $table->string('Email_client');
                $table->string('Responsable_projet');
                $table->string('Tel_responsable');
                $table->string('Email_responsable');
                $table->string('Personne_contacter');
                $table->string('Tel_personne');
                $table->string('Email_personne');
                $table->string('Fax_personne');
                $table->string('Numero_du_devis');
                $table->date('Date_de_la_commande');
                $table->string('Type_commande');
                $table->string('Modalite_paiement');
                $table->string('Numero_de_la_commande');
                $table->string('Conditions_de_paiement');
                $table->string('Agence');
                $table->string('Ingenieur_tecnitas');
                // Add more columns as needed
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affaires');
    }
};

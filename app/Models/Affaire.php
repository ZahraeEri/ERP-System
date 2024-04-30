<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affaire extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'affaires';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Numero',
        'Denomination',
        'Montant_Controle_plans_TTC',
        'Montant_Controle_travaux_TTC',
        'Montant_RC_TTC',
        'Montant_HT',
        'Type_de_lot',
        'Retenue_de_garantie',
        'Montant_Controle_plans_HT',
        'Montant_Controle_travaux_HT',
        'Montant_RC_HT',
        'TVA',
        'Montant_TVA',
        'Montant_RC_TVA',
        'Montant_TTC',
        'Mis_a_jour_par',
        'Montant_Controle_plans_TVA',
        'Montant_Controle_travaux_TVA',
        'Client',
        'Tel_client',
        'Adresse_chantier',
        'Maitre_doeuvre',
        'Fax',
        'BET',
        'Email_client',
        'Responsable_projet',
        'Tel_responsable',
        'Email_responsable',
        'Personne_contacter',
        'Tel_personne',
        'Email_personne',
        'Fax_personne',
        'Numero_du_devis',
        'Date_de_la_commande',
        'Type_commande',
        'Modalite_paiement',
        'Numero_de_la_commande',
        'Conditions_de_paiement',
        'Agence',
        'Ingenieur_tecnitas',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'ingenieur_tecnitas',
        'mod',
        'accuse_entree',
        'date_transmission',
        'architecte',
        'projet',
        'np',
        'bet',
        'accuse_sortie',
        'observation',
        'entreprise',
        'expediteur',
        'numero_ex',
        'etat_de_plan',
        'etat_de_transmission',
        'coordinateur',
    ];
}

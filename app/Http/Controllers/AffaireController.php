<?php

namespace App\Http\Controllers;

use App\Models\Affaire;
use App\Models\TypeDeLot;
use App\Models\RetenueDeGarantie;
use App\Models\TVA;
use App\Models\MisAJourPar;
use App\Models\Client;
use App\Models\TypeDeCommande;
use App\Models\ModaliteDePaiement;
use App\Models\Agence;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

class AffaireController extends Controller
{
    //
    public function affaires_list()
    {
        $affaires = Affaire::all(); // Fetching clients from the database
        return view('affaire.list-affaire', compact('affaires')); // Sending clients data to the view
    }
    public function addAffaire()
    {
        // Fetch options for select elements from the database
        $typeDeLotOptions = TypeDeLot::pluck('libelle', 'id');
        $retenueDeGarantieOptions = RetenueDeGarantie::pluck('libelle', 'id');
        $tvaOptions = TVA::pluck('libelle', 'id');
        $misAJourParOptions = MisAJourPar::pluck('libelle', 'id');
        $clients = Client::pluck('code', 'id');
        $typeDeCommandeOptions = TypeDeCommande::pluck('libelle', 'id');
        $modalitePaiementOptions = ModaliteDePaiement::pluck('libelle', 'id');
        $agenceOptions = Agence::pluck('libelle', 'id');

        return view('affaire.add-affaire', compact(
            'typeDeLotOptions',
            'retenueDeGarantieOptions',
            'tvaOptions',
            'misAJourParOptions',
            'clients',
            'typeDeCommandeOptions',
            'modalitePaiementOptions',
            'agenceOptions'
        ));
    }
    public function create(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'Numero' => 'required|string|max:255',
        'Denomination' => 'required|string|max:255',
        'Montant_Controle_plans_TTC' => 'required|numeric',
        'Montant_Controle_travaux_TTC' => 'required|numeric',
        'Montant_RC_TTC' => 'required|numeric',
        'Montant_HT' => 'required|numeric',
        'Type_de_lot' => 'required|exists:type_de_lot,id',
        'Retenue_de_garantie' => 'required|exists:retenue_de_garantie,id',
        'Montant_Controle_plans_HT' => 'required|numeric',
        'Montant_Controle_travaux_HT' => 'required|numeric',
        'Montant_RC_HT' => 'required|numeric',
        'TVA' => 'required|exists:tva,id',
        'Montant_TVA' => 'required|numeric',
        'Montant_RC_TVA' => 'required|numeric',
        'Montant_TTC' => 'required|numeric',
        'Mis_a_jour_par' => 'required|exists:mis_a_jour_par,id',
        'Montant_Controle_plans_TVA' => 'required|numeric',
        'Montant_Controle_travaux_TVA' => 'required|numeric',
        'Client' => 'required|exists:clients,id',
        'Tel_client' => 'nullable|string',
        'Adresse_chantier' => 'nullable|string',
        'Maitre_doeuvre' => 'nullable|string',
        'Fax' => 'nullable|string',
        'BET' => 'nullable|string',
        'Email_client' => 'nullable|email',
        'Responsable_projet' => 'nullable|string',
        'Tel_responsable' => 'nullable|string',
        'Email_responsable' => 'nullable|email',
        'Personne_contacter' => 'nullable|string',
        'Tel_personne' => 'nullable|string',
        'Email_personne' => 'nullable|email',
        'Fax_personne' => 'nullable|string',
        'Numero_du_devis' => 'nullable|string',
        'Date_de_la_commande' => 'nullable|date',
        'Type_commande' => 'required|exists:type_de_commande,id',
        'Modalite_paiement' => 'required|exists:modalite_de_paiement,id',
        'Numero_de_la_commande' => 'nullable|string',
        'Conditions_de_paiement' => 'nullable|string',
        'Agence' => 'required|exists:agence,id',
        'Ingenieur_tecnitas' => 'nullable|string',
    ]);

    // Create a new Affaire instance
    $affaire = new Affaire();

    // Assign validated data to Affaire attributes
    $affaire->Numero = $validatedData['Numero'];
    $affaire->Denomination = $validatedData['Denomination'];
    $affaire->Montant_Controle_plans_TTC = $validatedData['Montant_Controle_plans_TTC'];
    $affaire->Montant_Controle_travaux_TTC = $validatedData['Montant_Controle_travaux_TTC'];
    $affaire->Montant_RC_TTC = $validatedData['Montant_RC_TTC'];
    $affaire->Montant_HT = $validatedData['Montant_HT'];
    $affaire->Type_de_lot = $validatedData['Type_de_lot'];
    $affaire->Retenue_de_garantie = $validatedData['Retenue_de_garantie'];
    $affaire->Montant_Controle_plans_HT = $validatedData['Montant_Controle_plans_HT'];
    $affaire->Montant_Controle_travaux_HT = $validatedData['Montant_Controle_travaux_HT'];
    $affaire->Montant_RC_HT = $validatedData['Montant_RC_HT'];
    $affaire->TVA = $validatedData['TVA'];
    $affaire->Montant_TVA = $validatedData['Montant_TVA'];
    $affaire->Montant_RC_TVA = $validatedData['Montant_RC_TVA'];
    $affaire->Montant_TTC = $validatedData['Montant_TTC'];
    $affaire->Mis_a_jour_par = $validatedData['Mis_a_jour_par'];
    $affaire->Montant_Controle_plans_TVA = $validatedData['Montant_Controle_plans_TVA'];
    $affaire->Montant_Controle_travaux_TVA = $validatedData['Montant_Controle_travaux_TVA'];
    $affaire->Client = $validatedData['Client'];
    $affaire->Tel_client = $validatedData['Tel_client'];
    $affaire->Adresse_chantier = $validatedData['Adresse_chantier'];
    $affaire->Maitre_doeuvre = $validatedData['Maitre_doeuvre'];
    $affaire->Fax = $validatedData['Fax'];
    $affaire->BET = $validatedData['BET'];
    $affaire->Email_client = $validatedData['Email_client'];
    $affaire->Responsable_projet = $validatedData['Responsable_projet'];
    $affaire->Tel_responsable = $validatedData['Tel_responsable'];
    $affaire->Email_responsable = $validatedData['Email_responsable'];
    $affaire->Personne_contacter = $validatedData['Personne_contacter'];
    $affaire->Tel_personne = $validatedData['Tel_personne'];
    $affaire->Email_personne = $validatedData['Email_personne'];
    $affaire->Fax_personne = $validatedData['Fax_personne'];
    $affaire->Numero_du_devis = $validatedData['Numero_du_devis'];
    $affaire->Date_de_la_commande = $validatedData['Date_de_la_commande'];
    $affaire->Type_commande = $validatedData['Type_commande'];
    $affaire->Modalite_paiement = $validatedData['Modalite_paiement'];
    $affaire->Numero_de_la_commande = $validatedData['Numero_de_la_commande'];
    $affaire->Conditions_de_paiement = $validatedData['Conditions_de_paiement'];
    $affaire->Agence = $validatedData['Agence'];
    $affaire->Ingenieur_tecnitas = $validatedData['Ingenieur_tecnitas'];

    // Save the Affaire instance to the database
    $affaire->save();

    // Redirect to the list of affaires with a success message
    return redirect('/affaires')->with('status', 'Business created successfully!');
    //return redirect()->route('/affaires')->with('success', 'Affaire created successfully.');
}

public function delete($id)
{
    // Find the plan by ID and delete it
    Affaire::findOrFail($id)->delete();

    // Return a success response
    return response()->json(['message' => 'Affaire deleted successfully']);
}
public function showUpdateForm($id)
    {
        // Fetch the affaire to be updated
        $affaire = Affaire::findOrFail($id);

        // Fetch options for select elements from the database
        $typeDeLotOptions = TypeDeLot::pluck('libelle', 'id');
        $retenueDeGarantieOptions = RetenueDeGarantie::pluck('libelle', 'id');
        $tvaOptions = TVA::pluck('libelle', 'id');
        $misAJourParOptions = MisAJourPar::pluck('libelle', 'id');
        $clients = Client::pluck('code', 'id');
        $typeDeCommandeOptions = TypeDeCommande::pluck('libelle', 'id');
        $modalitePaiementOptions = ModaliteDePaiement::pluck('libelle', 'id');
        $agenceOptions = Agence::pluck('libelle', 'id');

        return view('affaire.update-affaire', compact(
            'affaire',
            'typeDeLotOptions',
            'retenueDeGarantieOptions',
            'tvaOptions',
            'misAJourParOptions',
            'clients',
            'typeDeCommandeOptions',
            'modalitePaiementOptions',
            'agenceOptions'
        ));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        // Validate the request data
        $validatedData = $request->validate([
            'Numero' => 'required|string|max:255',
            'Denomination' => 'required|string|max:255',
            'Montant_Controle_plans_TTC' => 'required|numeric',
            'Montant_Controle_travaux_TTC' => 'required|numeric',
            'Montant_RC_TTC' => 'required|numeric',
            'Montant_HT' => 'required|numeric',
            'Type_de_lot' => 'required|exists:type_de_lot,id',
            'Retenue_de_garantie' => 'required|exists:retenue_de_garantie,id',
            'Montant_Controle_plans_HT' => 'required|numeric',
            'Montant_Controle_travaux_HT' => 'required|numeric',
            'Montant_RC_HT' => 'required|numeric',
            'TVA' => 'required|exists:tva,id',
            'Montant_TVA' => 'required|numeric',
            'Montant_RC_TVA' => 'required|numeric',
            'Montant_TTC' => 'required|numeric',
            'Mis_a_jour_par' => 'required|exists:mis_a_jour_par,id',
            'Montant_Controle_plans_TVA' => 'required|numeric',
            'Montant_Controle_travaux_TVA' => 'required|numeric',
            'Client' => 'required|exists:clients,id',
            'Tel_client' => 'nullable|string',
            'Adresse_chantier' => 'nullable|string',
            'Maitre_doeuvre' => 'nullable|string',
            'Fax' => 'nullable|string',
            'BET' => 'nullable|string',
            'Email_client' => 'nullable|email',
            'Responsable_projet' => 'nullable|string',
            'Tel_responsable' => 'nullable|string',
            'Email_responsable' => 'nullable|email',
            'Personne_contacter' => 'nullable|string',
            'Tel_personne' => 'nullable|string',
            'Email_personne' => 'nullable|email',
            'Fax_personne' => 'nullable|string',
            'Numero_du_devis' => 'nullable|string',
            'Date_de_la_commande' => 'nullable|date',
            'Type_commande' => 'required|exists:type_de_commande,id',
            'Modalite_paiement' => 'required|exists:modalite_de_paiement,id',
            'Numero_de_la_commande' => 'nullable|string',
            'Conditions_de_paiement' => 'nullable|string',
            'Agence' => 'required|exists:agence,id',
            'Ingenieur_tecnitas' => 'nullable|string',
        ]);

        // Find the affaire by ID
        $affaire = Affaire::findOrFail($id);

        // Update the affaire with the request data
        $affaire->update($validatedData);

        // Redirect to the list of affaires with a success message
        return redirect('/affaires')->with('status', 'Business updated successfully!');
    }
}

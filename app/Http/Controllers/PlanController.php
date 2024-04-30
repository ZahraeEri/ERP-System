<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EtatDePlan;
use App\Models\EtatDeTransmission;
use App\Models\Plan;

class PlanController extends Controller
{
    public function plans_list()
    {
        $plans = Plan::all(); // Fetching plans from the database
        return view('plan.list-plan', compact('plans')); // Sending plans data to the view
    }

    //
    public function addplan()
    {
        // Fetch options for 'etat' select element
    $etatOptions = EtatDePlan::all();

    // Fetch options for 'etat_transmission' select element
    $etatTransmissionOptions = EtatDeTransmission::all();

    return view('plan.add-plan', compact('etatOptions', 'etatTransmissionOptions'));
    }
    public function create(Request $request)
{
    // Validation logic goes here
    $request->validate([
        'date' => 'required|date',
        'projet' => 'required|string',
        'expediteur' => 'required|string',
        'ingenieur_tecnitas' => 'required|string',
        'np' => 'required|string',
        'numero_ex' => 'required|string',
        'mod' => 'required|string',
        'bet' => 'required|string',
        'etat_de_plan' => 'required|exists:etat_de_plan,id',
        'accuse_entree' => 'required|string',
        'accuse_sortie' => 'required|string',
        'etat_de_transmission' => 'required|exists:etat_de_transmission,id',
        'date_transmission' => 'required|date',
        'observation' => 'required|string',
        'Coordinateur' => 'required|string',
        'architecte' => 'required|string',
        'entreprise' => 'required|string',
    ]);

    // Fetch the corresponding libelle for etat_de_plan
    $etatDePlan = EtatDePlan::findOrFail($request->input('etat_de_plan'));
    $etatDePlanLibelle = $etatDePlan->libelle;

    // Fetch the corresponding libelle for etat_de_transmission
    // $etatDeTransmission = EtatDeTransmission::findOrFail($request->input('etat_de_transmission'));
    // $etatDeTransmissionLibelle = $etatDeTransmission->libelle;

    // Create a new plan instance
    $plan = new Plan();
    $plan->date = $request->input('date');
    $plan->projet = $request->input('projet');
    $plan->expediteur = $request->input('expediteur');
    $plan->ingenieur_tecnitas = $request->input('ingenieur_tecnitas');
    $plan->np = $request->input('np');
    $plan->numero_ex = $request->input('numero_ex');
    $plan->mod = $request->input('mod');
    $plan->bet = $request->input('bet');
    $plan->etat_de_plan = $request->input('etat_de_plan'); // Save the libelle instead of id
    $plan->accuse_entree = $request->input('accuse_entree');
    $plan->accuse_sortie = $request->input('accuse_sortie');
    $plan->etat_de_transmission = $request->input('etat_de_transmission'); // Save the libelle instead of id
    $plan->date_transmission = $request->input('date_transmission');
    $plan->observation = $request->input('observation');
    $plan->Coordinateur = $request->input('Coordinateur');
    $plan->architecte = $request->input('architecte');
    $plan->entreprise = $request->input('entreprise');

    // Save the plan
    $plan->save();

    // Redirect with success message
    return redirect('/plans')->with('status', 'Plan added successfully!');
}
public function delete($id)
{
    // Find the plan by ID and delete it
    Plan::findOrFail($id)->delete();

    // Return a success response
    return response()->json(['message' => 'Plan deleted successfully']);
}


public function showUpdateForm($id)
{
    // Fetch options for 'etat' select element
    $etatOptions = EtatDePlan::all();

    // Fetch options for 'etat_transmission' select element
    $etatTransmissionOptions = EtatDeTransmission::all();

    // Fetch the plan to be updated
    $plan = Plan::findOrFail($id);

    // Pass the fetched data to the update plan view
    return view('plan.update-plan', compact('plan', 'etatOptions', 'etatTransmissionOptions'));
}



public function update(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'date' => 'required|date',
        'projet' => 'required|string',
        'expediteur' => 'required|string',
        'ingenieur_tecnitas' => 'required|string',
        'np' => 'required|string',
        'numero_ex' => 'required|string',
        'mod' => 'required|string',
        'bet' => 'required|string',
        'etat_de_plan' => 'required|exists:etat_de_plan,id',
        'accuse_entree' => 'required|string',
        'accuse_sortie' => 'required|string',
        'etat_de_transmission' => 'required|exists:etat_de_transmission,id',
        'date_transmission' => 'required|date',
        'observation' => 'required|string',
        'Coordinateur' => 'required|string',
        'architecte' => 'required|string',
        'entreprise' => 'required|string',
    ]);

    // Fetch the corresponding libelle for etat_de_plan
    // $etatDePlan = EtatDePlan::findOrFail($request->input('etat_de_plan'));
    // $etatDePlanLibelle = $etatDePlan->libelle;

    // Fetch the corresponding libelle for etat_de_transmission
    // $etatDeTransmission = EtatDeTransmission::findOrFail($request->input('etat_de_transmission'));
    // $etatDeTransmissionLibelle = $etatDeTransmission->libelle;

    // Find the plan by ID
    $plan = Plan::findOrFail($id);

    // Update the plan with the request data
    $plan->update([
        'date' => $request->input('date'),
        'projet' => $request->input('projet'),
        'expediteur' => $request->input('expediteur'),
        'ingenieur_tecnitas' => $request->input('ingenieur_tecnitas'),
        'np' => $request->input('np'),
        'numero_ex' => $request->input('numero_ex'),
        'mod' => $request->input('mod'),
        'bet' => $request->input('bet'),
        'etat_de_plan' => $request->input('etat_de_plan'), // Save the libelle instead of id
        'accuse_entree' => $request->input('accuse_entree'),
        'accuse_sortie' => $request->input('accuse_sortie'),
        'etat_de_transmission' => $request->input('etat_de_transmission'), // Save the libelle instead of id
        'date_transmission' => $request->input('date_transmission'),
        'observation' => $request->input('observation'),
        'Coordinateur' => $request->input('Coordinateur'),
        'architecte' => $request->input('architecte'),
        'entreprise' => $request->input('entreprise'),
    ]);

    // Redirect with success message
    return redirect('/plans')->with('status', 'Plan updated successfully!');
}




}

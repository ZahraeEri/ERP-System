<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use  App\Models\User;
use App\Models\Agence;
use App\Models\ConditionDePaiement;
use App\Models\EtatDeLot;
use App\Models\EtatDePlan;
use App\Models\EtatDeTransmission;
use App\Models\MisAJourPar;
use App\Models\ModaliteDePaiement;
use App\Models\RetenueDeGarantie;
use App\Models\StatutDAffaire;
use App\Models\TypeDAffaire;
use App\Models\TypeDAppel;
use App\Models\TypeDeCommande;
use App\Models\TypeDeDocumentAdministratif;
use App\Models\TypeDeDocumentTechnique;
use App\Models\TypeDeLot;
use App\Models\TVA;

class SettingsController extends Controller
{
    public function table_list()
    {
        // Define the tables you want to include
        $includedTables = [
            'agence',
            'conditions_de_paiement',
            'etat_de_lot',
            'etat_de_plan',
            'etat_de_transmission',
            'mis_a_jour_par',
            'modalite_de_paiement',
            'retenue_de_garantie',
            'statut_d_affaire',
            'type_d_affaire',
            'type_d_appel',
            'type_de_commande',
            'type_de_document_administratif',
            'type_de_document_technique',
            'type_de_lot',
            'tva',
        ];

        // Fetch table names from the database
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);

        // Filter table names to include only the ones in the $includedTables array
        $filteredTableNames = array_intersect($tableNames, $includedTables);

        // Check if any tables are found
        if (empty($filteredTableNames)) {
            // Handle the case where no tables are found
            return "No tables found.";
        }

        // Assuming you want to pass the first table name for demonstration purposes
        $tableName = $filteredTableNames[1];

        // Fetch data from the selected table
        $data = DB::table($tableName)->get();

        // Check if data is retrieved successfully
        if ($data->isEmpty()) {
            // Handle the case where no data is retrieved
            return "No data found for table: $tableName";
        }

        return view('settings.table_list', compact('filteredTableNames', 'tableName', 'data'));
    }




public function deleteParameter(Request $request){
    // Get the type of the table from the request
    $type = $request->input("type");

    // Handle deletion based on the type
    if ($type === 'agence') {
        $agence = Agence::find($request->input("idDelParameter"));
        $agence->delete();
        return "Row deleted successfully";
    }

    if ($type === 'condition_de_paiement') {
        $conditionPaiement = ConditionDePaiement::find($request->input("idDelParameter"));
        $conditionPaiement->delete();
        return "Row deleted successfully";
    }

    if ($type === 'etat_de_lot') {
        $etatLot = EtatDeLot::find($request->input("idDelParameter"));
        $etatLot->delete();
        return "Row deleted successfully";
    }

    // Add cases for other tables similarly
    if ($type === 'etat_de_plan') {
        $etatPlan = EtatDePlan::find($request->input("idDelParameter"));
        $etatPlan->delete();
        return "Row deleted successfully";
    }

    if ($type === 'etat_de_transmission') {
        $etatTransmission = EtatDeTransmission::find($request->input("idDelParameter"));
        $etatTransmission->delete();
        return "Row deleted successfully";
    }

    if ($type === 'mis_a_jour_par') {
        $misAJourPar = MisAJourPar::find($request->input("idDelParameter"));
        $misAJourPar->delete();
        return "Row deleted successfully";
    }

    if ($type === 'modalite_de_paiement') {
        $modalitePaiement = ModaliteDePaiement::find($request->input("idDelParameter"));
        $modalitePaiement->delete();
        return "Row deleted successfully";
    }

    if ($type === 'retenue_de_garantie') {
        $retenueGarantie = RetenueDeGarantie::find($request->input("idDelParameter"));
        $retenueGarantie->delete();
        return "Row deleted successfully";
    }

    if ($type === 'statut_d_affaire') {
        $statutAffaire = StatutDAffaire::find($request->input("idDelParameter"));
        $statutAffaire->delete();
        return "Row deleted successfully";
    }

    if ($type === 'type_d_affaire') {
        $typeAffaire = TypeDAffaire::find($request->input("idDelParameter"));
        $typeAffaire->delete();
        return "Row deleted successfully";
    }

    if ($type === 'type_d_appel') {
        $typeAppel = TypeDAppel::find($request->input("idDelParameter"));
        $typeAppel->delete();
        return "Row deleted successfully";
    }

    if ($type === 'type_de_commande') {
        $typeCommande = TypeDeCommande::find($request->input("idDelParameter"));
        $typeCommande->delete();
        return "Row deleted successfully";
    }

    if ($type === 'type_de_document_administratif') {
        $typeDocumentAdministratif = TypeDeDocumentAdministratif::find($request->input("idDelParameter"));
        $typeDocumentAdministratif->delete();
        return "Row deleted successfully";
    }

    if ($type === 'type_de_document_technique') {
        $typeDocumentTechnique = TypeDeDocumentTechnique::find($request->input("idDelParameter"));
        $typeDocumentTechnique->delete();
        return "Row deleted successfully";
    }

    if ($type === 'type_de_lot') {
        $typeLot = TypeDeLot::find($request->input("idDelParameter"));
        $typeLot->delete();
        return "Row deleted successfully";
    }

    if ($type === 'tva') {
        $tva = TVA::find($request->input("idDelParameter"));
        $tva->delete();
        return "Row deleted successfully";
    }

    return "Invalid table type";
}
public function fetchParameterData($tableName, $id)
{
    // Define the model class based on the table name
    $modelClass = $this->getModelClass($tableName);

    if (!$modelClass) {
        return response()->json(['error' => 'Invalid table name'], 404);
    }

    // Find the parameter by ID
    $parameter = $modelClass::find($id);

    if ($parameter) {
        return response()->json($parameter);
    } else {
        return response()->json(['error' => 'Parameter not found'], 404);
    }
}


// Helper method to get model class based on table name
private function getModelClass($tableName)
{
    switch ($tableName) {
        case 'agence':
            return Agence::class;
        case 'conditions_de_paiement':
            return ConditionDePaiement::class;
        case 'etat_de_lot':
            return EtatDeLot::class;
        case 'tva':
            return TVA::class;
        // Add cases for other models similarly
        default:
            return null;
    }
}




    public function fetchTableData(Request $request)
    {
        // Get the table name from the request
        // $tableName = $request->input('table');
        $tableName = $request->tableName;

        // Fetch data from the selected table
        $data = DB::table($tableName)->get();

        // Return the data as a response to the AJAX call
        return $data;
        // return response()->json($data);
    }
    public function deleteTableRow(Request $request, $id)
{
  $tableName = $request->input('table');

//   dd($id);

  try {
    DB::table($tableName)->where('id', $id)->delete();
    return response()->json(['message' => 'Row deleted successfully']);
  } catch (\Exception $e) {
    // Log the error for debugging
    Log::error('Error deleting row: ' . $e->getMessage());
    return response()->json(['message' => 'An unexpected error occurred. Please try again later.'], 500);
  }
}

public function addParameter(Request $request)
{
    // Get the type of the table from the request
    $type = $request->input("type");

    // Handle addition based on the type
    switch ($type) {
        case 'agence':
            Agence::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
        case 'conditions_de_paiement':
            ConditionDePaiement::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
        case 'etat_de_lot':
            EtatDeLot::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
        case 'etat_de_plan':
            EtatDePlan::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
        case 'etat_de_transmission':
            EtatDeTransmission::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
        case 'mis_a_jour_par':
            MisAJourPar::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
        case 'modalite_de_paiement':
            ModaliteDePaiement::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
        case 'retenue_de_garantie':
            RetenueDeGarantie::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
        case 'statut_d_affaire':
            StatutDAffaire::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
        case 'type_d_affaire':
            TypeDAffaire::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
        case 'type_d_appel':
            TypeDAppel::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
        case 'type_de_commande':
            TypeDeCommande::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
        case 'type_de_document_administratif':
            TypeDeDocumentAdministratif::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
        case 'type_de_document_technique':
            TypeDeDocumentTechnique::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
        case 'type_de_lot':
            TypeDeLot::create(['libelle' => $request->input("libelle")]);
            return "Parameter added successfully";
            case 'tva':
                TVA::create([
                    'libelle' => $request->input("libelle"),
                    'valeur' => $request->input("valeur")
                ]);
                return "Parameter added successfully";
        default:
            return "Invalid table type";
    }
}


    public function editParameter(Request $request)
{
    // Get the type of the table from the request
    $type = $request->input("type");

    // Handle edit based on the type
    if ($type === 'agence') {
        $agence = Agence::find($request->input("idEditParameter"));
        $agence->libelle =  $request->input("editLibelle");
        $agence->save();
        return "Row edited successfully";
    }

    if ($type === 'condition_de_paiement') {
        $conditionPaiement = ConditionDePaiement::find($request->input("idEditParameter"));
        $conditionPaiement->libelle =  $request->input("editLibelle");
        $conditionPaiement->save();
        return "Row edited successfully";
    }

    if ($type === 'etat_de_lot') {
        $etatLot = EtatDeLot::find($request->input("idEditParameter"));
        $etatLot->libelle =  $request->input("editLibelle");
        $etatLot->save();
        return "Row edited successfully";
    }

    // Add cases for other tables similarly

    if ($type === 'etat_de_plan') {
        $etatPlan = EtatDePlan::find($request->input("idEditParameter"));
        $etatPlan->libelle =  $request->input("editLibelle");
        $etatPlan->save();
        return "Row edited successfully";
    }

    if ($type === 'etat_de_transmission') {
        $etatTransmission = EtatDeTransmission::find($request->input("idEditParameter"));
        $etatTransmission->libelle =  $request->input("editLibelle");
        $etatTransmission->save();
        return "Row edited successfully";
    }

    if ($type === 'mis_a_jour_par') {
        $misAJourPar = MisAJourPar::find($request->input("idEditParameter"));
        $misAJourPar->libelle =  $request->input("editLibelle");
        $misAJourPar->save();
        return "Row edited successfully";
    }

    if ($type === 'modalite_de_paiement') {
        $modalitePaiement = ModaliteDePaiement::find($request->input("idEditParameter"));
        $modalitePaiement->libelle =  $request->input("editLibelle");
        $modalitePaiement->save();
        return "Row edited successfully";
    }

    if ($type === 'retenue_de_garantie') {
        $retenueGarantie = RetenueDeGarantie::find($request->input("idEditParameter"));
        $retenueGarantie->libelle =  $request->input("editLibelle");
        $retenueGarantie->save();
        return "Row edited successfully";
    }

    if ($type === 'statut_d_affaire') {
        $statutAffaire = StatutDAffaire::find($request->input("idEditParameter"));
        $statutAffaire->libelle =  $request->input("editLibelle");
        $statutAffaire->save();
        return "Row edited successfully";
    }

    if ($type === 'type_d_affaire') {
        $typeAffaire = TypeDAffaire::find($request->input("idEditParameter"));
        $typeAffaire->libelle =  $request->input("editLibelle");
        $typeAffaire->save();
        return "Row edited successfully";
    }

    if ($type === 'type_d_appel') {
        $typeAppel = TypeDAppel::find($request->input("idEditParameter"));
        $typeAppel->libelle =  $request->input("editLibelle");
        $typeAppel->save();
        return "Row edited successfully";
    }

    if ($type === 'type_de_commande') {
        $typeCommande = TypeDeCommande::find($request->input("idEditParameter"));
        $typeCommande->libelle =  $request->input("editLibelle");
        $typeCommande->save();
        return "Row edited successfully";
    }

    if ($type === 'type_de_document_administratif') {
        $typeDocumentAdministratif = TypeDeDocumentAdministratif::find($request->input("idEditParameter"));
        $typeDocumentAdministratif->libelle =  $request->input("editLibelle");
        $typeDocumentAdministratif->save();
        return "Row edited successfully";
    }

    if ($type === 'type_de_document_technique') {
        $typeDocumentTechnique = TypeDeDocumentTechnique::find($request->input("idEditParameter"));
        $typeDocumentTechnique->libelle =  $request->input("editLibelle");
        $typeDocumentTechnique->save();
        return "Row edited successfully";
    }

    if ($type === 'type_de_lot') {
        $typeLot = TypeDeLot::find($request->input("idEditParameter"));
        $typeLot->libelle =  $request->input("editLibelle");
        $typeLot->save();
        return "Row edited successfully";
    }

    if ($type === 'tva') {
        $tva = TVA::find($request->input("idEditParameter"));
        $tva->libelle =  $request->input("editLibelle");
        $tva->save();
        return "Row edited successfully";
    }

    return "Invalid table type";
}

}


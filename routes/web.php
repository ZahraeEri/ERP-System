<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use  App\Http\Controllers\UserController;
use  App\Http\Controllers\PlanController;
use  App\Http\Controllers\ClientController;
use  App\Http\Controllers\AffaireController;
use Illuminate\Http\Request;
use App\Models\TVA; // Assurez-vous d'importer le modèle TVA approprié
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/login', function () {
//     return view('auth.login');
// });
Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        return redirect('/login');
    }
});


//user
Route::middleware(['auth'])->group(function () {
    Route::get('/user', [UserController::class, 'users_list'])->name('list.user');
    Route::get('/add', [UserController::class, 'users_add']);
    Route::post('/add/treatment', [UserController::class, 'users_add_treatment']);
    Route::get('/update-user/{id}', [UserController::class, 'update_user']);
    Route::post('/update/treatment', [UserController::class, 'users_update_treatment']);
    Route::get('/delete-user/{id}', [UserController::class, 'delete_user']);
});
//settings
Route::middleware('auth')->group(function () {
    Route::get('/settings', [SettingsController::class, 'table_list'])->name('table_list.settings');
    Route::get('/settings/fetch-table-data', [SettingsController::class, 'fetchTableData'])->name('settings.fetch-table-data');
    //Route::get('/add-new-data', [SettingsController::class, 'data_add']);
    Route::delete('/delete-parameter', [SettingsController::class, 'deleteParameter'])->name('delete-parameter');
    Route::get('/settings/fetch-parameter-data/{tableName}/{id}', [SettingsController::class, 'fetchParameterData']);
    Route::post('/edit-parameter', [SettingsController::class, 'editParameter'])->name('edit-parameter');
    Route::post('/add-parameter', [SettingsController::class, 'addParameter'])->name('add-parameter');
});
//plans
Route::middleware('auth')->group(function () {
    Route::get('/plans', [PlanController::class, 'plans_list'])->name('list-plan.plan'); // Route to show the list table
    Route::get('/add_plan', [PlanController::class, 'addplan'])->name('add-plan.plan');
    Route::post('/add/plan', [PlanController::class, 'create'])->name('plan.create');
    Route::delete('/delete-plan/{id}', [PlanController::class, 'delete'])->name('plan.delete');
    // Route to show the update plan view
    Route::get('/update-plan/{id}', [PlanController::class, 'showUpdateForm'])->name('plan.show-update-form');

    // Route to handle plan update
    Route::post('/update-plan-treatment/{id}', [PlanController::class, 'update'])->name('plan.update');
});
//clients
Route::middleware('auth')->group(function () {
    Route::get('/clients', [ClientController::class, 'clients_list'])->name('list-client.client'); // Route pour afficher la liste des clients
    Route::get('/add_client', [ClientController::class, 'addClient'])->name('add-client.client'); // Route pour afficher le formulaire d'ajout de client
    Route::post('/add/client', [ClientController::class, 'create'])->name('client.create'); // Route pour créer un nouveau client
    Route::delete('/delete-client/{id}', [ClientController::class, 'delete'])->name('client.delete'); // Route pour supprimer un client
    // // Route pour afficher la vue de mise à jour du client
    Route::get('/update-client/{id}', [ClientController::class, 'showUpdateForm'])->name('client.show-update-form');
    // // Route pour gérer la mise à jour du client
    Route::post('/update-client-treatment/{id}', [ClientController::class, 'update'])->name('client.update');
});
//affaires
Route::middleware('auth')->group(function () {
    Route::get('/affaires', [AffaireController::class, 'affaires_list'])->name('list-affaire.affaire'); // Route pour afficher la liste des clients
    Route::get('/add_affaire', [AffaireController::class, 'addAffaire'])->name('add-affaire.affaire'); // Route pour afficher le formulaire d'ajout de client
    Route::post('/add/affaire', [AffaireController::class, 'create'])->name('add/affaire');
    Route::delete('/delete-affaire/{id}', [AffaireController::class, 'delete'])->name('affaire.delete'); // Route pour supprimer un client
    // // Route pour afficher la vue de mise à jour du client
    Route::get('/update-affaire/{id}', [AffaireController::class, 'showUpdateForm'])->name('affaire.show-update-form');
    // Route pour gérer la mise à jour du client
    Route::post('/update-affaire-treatment/{id}', [AffaireController::class, 'update'])->name('affaire.update');


    Route::get('/get-tva-value', function (Request $request) {
        $id = $request->input('id');
        $tva = TVA::find($id); // Supposons que vous ayez un modèle TVA avec une colonne 'value'
        if ($tva) {
            return response()->json(['montantTVA' => $tva->valeur]);
        } else {
            return response()->json(['montantTVA' => 0]); // Gérer le cas où l'identifiant n'est pas trouvé
        }
    });
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// useless routes
// Just to demo sidebar dropdown links active states.
// Route::get('/user', function () {
//     return view('user.list');
// })->middleware(['auth'])->name('list.user');
//Route::get('/user', [UserController::class, 'users_list'])->middleware(['auth'])->name('list.user');


// Route::get('/buttons/icon', function () {
//     return view('buttons-showcase.icon');
// })->middleware(['auth'])->name('buttons.icon');

Route::get('/buttons/text-icon', function () {
    return view('buttons-showcase.text-icon');
})->middleware(['auth'])->name('buttons.text-icon');

require __DIR__ . '/auth.php';

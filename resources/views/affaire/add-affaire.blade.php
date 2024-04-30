<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Add a new Business
        </h2>
    </x-slot>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add a new business</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- jquery and jquery UI libraries  -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>

    <div class="container mx-auto sm:px-4 mt-3">
        @if (session('status'))
            <div class="relative px-3 py-3 mb-4 border rounded bg-green-200 border-green-300 text-green-800">
                {{ session('status') }}
            </div>
        @endif
        <ul>
            @foreach ($errors->all() as $error)
                <li class="relative px-3 py-3 mb-4 border rounded bg-red-200 border-red-300 text-red-800">
                    {{ $error }}
                </li>
            @endforeach
        </ul>
        <form method="POST" action="{{ route('add/affaire') }}" enctype="multipart/form-data">
            {{-- <form action="/add/affaire" method="post" > --}}
            @csrf
            <!-- Affaire details -->
            <div class="row mb-3">
                <!-- Numero -->
                <div class="col-md-4">
                    <label for="Numero" class="form-label">Number</label>
                    <input type="text" class="form-control" id="Numero" name="Numero" required>
                </div>
                {{-- type de lot --}}
                <div class="col-md-4">
                    <label for="Type_de_lot" class="form-label">Type of Lot</label>
                    <select class="form-select" id="Type_de_lot" name="Type_de_lot" required>
                        <option value="">Select an item</option>
                        <!-- Loop through typeDeLotOptions -->
                        @foreach ($typeDeLotOptions as $id => $libelle)
                            <option value="{{ $id }}">{{ $libelle }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- mise a jour par --}}
                <div class="col-md-4">
                    <label for="Mis_a_jour_par" class="form-label">Updated by</label>
                    <select class="form-select" id="Mis_a_jour_par" name="Mis_a_jour_par" required>
                        <option value="">Select an item</option>
                        <!-- Loop through misAJourParOptions -->
                        @foreach ($misAJourParOptions as $id => $libelle)
                            <option value="{{ $id }}">{{ $libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Denomination -->
                <div class="col-md-4">
                    <label for="Denomination" class="form-label">Denomination</label>
                    <input type="text" class="form-control" id="Denomination" name="Denomination" required>
                </div>
                <!-- Retenue de garantie -->
                <div class="col-md-8">
                    <label for="Retenue_de_garantie" class="form-label">Retention Guarantee</label>
                    <select class="form-select" id="Retenue_de_garantie" name="Retenue_de_garantie" required>
                        <option value="">Select an item</option>
                        <!-- Loop through retenueDeGarantieOptions -->
                        @foreach ($retenueDeGarantieOptions as $id => $libelle)
                            <option value="{{ $id }}">{{ $libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Montant Controle plans TTC -->
                <div class="col-md-4">
                    <label for="Montant_Controle_plans_TTC" class="form-label">Total Cost Control Amount TTC</label>
                    <input type="text" class="form-control" id="Montant_Controle_plans_TTC"
                        name="Montant_Controle_plans_TTC" required>
                </div>
                <!-- Montant Controle plans HT -->
                <div class="col-md-4">
                    <label for="Montant_Controle_plans_HT" class="form-label">Total Cost Control Amount (HT)</label>
                    <input type="text" class="form-control" id="Montant_Controle_plans_HT"
                        name="Montant_Controle_plans_HT" required>
                </div>
                <!-- Montant Controle plans TVA -->
                <div class="col-md-4">
                    <label for="Montant_Controle_plans_TVA" class="form-label">Total Cost Control Amount VAT</label>
                    <input type="text" class="form-control" id="Montant_Controle_plans_TVA"
                        name="Montant_Controle_plans_TVA" required>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Montant Controle des travaux TTC -->
                <div class="col-md-4">
                    <label for="Montant_Controle_travaux_TTC" class="form-label"> Total Work Control Amount TTC
                        </label>
                    <input type="text" class="form-control" id="Montant_Controle_travaux_TTC"
                        name="Montant_Controle_travaux_TTC" required>
                </div>
                <!-- Montant Controle des travaux HT -->
                <div class="col-md-4">
                    <label for="Montant_Controle_travaux_HT" class="form-label">Total Cost Control Amount (HT)</label>
                    <input type="text" class="form-control" id="Montant_Controle_travaux_HT"
                        name="Montant_Controle_travaux_HT" required>
                </div>
                <!-- Montant Controle des travaux TVA -->
                <div class="col-md-4">
                    <label for="Montant_Controle_travaux_TVA" class="form-label"> Total Work Control Amount VAT
                    </label>
                    <input type="text" class="form-control" id="Montant_Controle_travaux_TVA"
                        name="Montant_Controle_travaux_TVA" required>
                </div>
                <!-- Montant RC TTC -->
                <div class="col-md-4">
                    <label for="Montant_RC_TTC" class="form-label">Total RC Amount TTC</label>
                    <input type="text" class="form-control" id="Montant_RC_TTC" name="Montant_RC_TTC" required>
                </div>
                <!-- Montant RC HT -->
                <div class="col-md-4">
                    <label for="Montant_RC_HT" class="form-label">Total RC Amount(HT)</label>
                    <input type="text" class="form-control" id="Montant_RC_HT" name="Montant_RC_HT" required>
                </div>
                <!-- Montant RC TVA -->
                <div class="col-md-4">
                    <label for="Montant_RC_TVA" class="form-label"> RC VAT Amount</label>
                    <input type="text" class="form-control" id="Montant_RC_TVA" name="Montant_RC_TVA" required>
                </div>

            </div>

            <!-- Type de lot -->
            <div class="row mb-4">
                <!-- Montant HT -->
                <div class="col-md-3">
                    <label for="Montant_HT" class="form-label">Total Amount (HT)</label>
                    <input type="text" class="form-control" id="Montant_HT" name="Montant_HT"
                        required>
                </div>
                <!-- TVA -->
                <div class="col-md-3">
                    <label for="TVA" class="form-label">TVA</label>
                    <select class="form-select" id="TVA" name="TVA"
                        required>
                        <option value="">Select an item</option>
                        <!-- Loop through tvaOptions -->
                        @foreach ($tvaOptions as $id => $libelle)
                            <option value="{{ $id }}">{{ $libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Montant TVA -->
                <div class="col-md-3">
                    <label for="Montant_TVA" class="form-label">VAT Amount (TVA)</label>
                    <input type="text" class="form-control" id="Montant_TVA" name="Montant_TVA" required>
                </div>

                <!-- Montant TTC -->
                <div class="col-md-3">
                    <label for="Montant_TTC" class="form-label"> TTC Amount</label>
                    <input type="text" class="form-control" id="Montant_TTC" name="Montant_TTC" required>
                </div>
            </div>

            {{-- <script>
                $(document).ready(function() {
                    $('#TVA').change(function() {
                        calculateTVAandTTC();
                    });

                    // $('#Montant_HT').change(function() {
                    //     calculateTVAandTTC();
                    // });

                    function calculateTVAandTTC() {
                        var tva = $("#TVA").val();
                        alert(tva);
                        var montantHT = parseFloat(document.getElementById('Montant_HT').value);
                        var tvaValue = parseFloat($('#TVA option:selected').data(
                        'valeur')); // Retrieve value from data attribute
                        var montantTVA = montantHT * (tvaValue / 100); // Calculate TVA based on percentage
                        document.getElementById('Montant_TVA').value = montantTVA.toFixed(2);

                        var montantTTC = montantHT + montantTVA;
                        document.getElementById('Montant_TTC').value = montantTTC.toFixed(2);
                    }
                });
            </script> --}}
            <script>
                $(document).ready(function() {
                    $('#TVA').change(function() {
                        var selectedTVAId = $(this).val();
                        getTVAValue(selectedTVAId);
                    });

                    function getTVAValue(tvaId) {
                        $.ajax({
                            url: '/get-tva-value', // Endpoint to handle the request
                            method: 'GET',
                            data: { id: tvaId },
                            success: function(response) {
                                $('#Montant_TVA').val(response.montantTVA); // Update the TVA field with the returned value
                                // Recalculate TTC based on HT and the returned TVA value
                                var montantHT = parseFloat($('#Montant_HT').val());
                                var montantTVA = parseFloat(response.montantTVA);
                                var montantTTC = montantHT + montantTVA;
                                $('#Montant_TTC').val(montantTTC.toFixed(2)); // Update the TTC field
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    }
                });
            </script>














            <hr>
            <!-- Client details -->
            <div class="row mb-3">
                <!-- Client -->
                <div class="col-md-4">
                    <label for="Client" class="form-label">Client</label>
                    <select class="form-select" id="Client" name="Client" required>
                        <option value="">Select a client</option>
                        <!-- Loop through clients -->
                        @foreach ($clients as $id => $libelle)
                            <option value="{{ $id }}">{{ $libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Maitre d'oeuvre -->
                <div class="col-md-4">
                    <label for="Maitre_doeuvre" class="form-label">Project Manager</label>
                    <input type="text" class="form-control" id="Maitre_doeuvre" name="Maitre_doeuvre" required>
                </div>
                <!-- B.E.T -->
                <div class="col-md-4">
                    <label for="BET" class="form-label">B.E.T</label>
                    <input type="text" class="form-control" id="BET" name="BET" required>
                </div>
            </div>
            <div class="row mb-3">
                <!-- Tel_client -->
                <div class="col-md-4">
                    <label for="Tel_client" class="form-label">Tel_client</label>
                    <input type="text" class="form-control" id="Tel_client" name="Tel_client" required>
                </div>

                <!-- Fax -->
                <div class="col-md-4">
                    <label for="Fax" class="form-label">Fax</label>
                    <input type="text" class="form-control" id="Fax" name="Fax" required>
                </div>
                <!-- Email_client -->

                <div class="col-md-4">
                    <label for="Email_client" class="form-label">Email_client</label>
                    <input type="email" class="form-control" id="Email_client" name="Email_client" required>
                </div>
            </div>



            <div class="row mb-3">

                <!-- Adresse chantier -->
                <div class="col-md-4">
                    <label for="Adresse_chantier" class="form-label">Site Address</label>
                    <input type="text" class="form-control" id="Adresse_chantier" name="Adresse_chantier"
                        required>
                </div>

            </div>


            <hr>
            <!-- Responsable projet -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="Responsable_projet" class="form-label"> Project Responsable</label>
                    <input type="text" class="form-control" id="Responsable_projet" name="Responsable_projet"
                        required>
                </div>

                <!-- Tel_responsable -->
                <div class="col-md-4">
                    <label for="Tel_responsable" class="form-label">Tel</label>
                    <input type="text" class="form-control" id="Tel_responsable" name="Tel_responsable" required>
                </div>
                <!-- Email_responsable -->
                <div class="col-md-4">
                    <label for="Email_responsable" class="form-label">Email</label>
                    <input type="email" class="form-control" id="Email_responsable" name="Email_responsable"
                        required>
                </div>
            </div>
            <hr>
            <!-- Personne contacter -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="Personne_contacter" class="form-label">Contact Person</label>
                    <input type="text" class="form-control" id="Personne_contacter" name="Personne_contacter"
                        required>
                </div>
                <!-- Tel_personne -->
                <div class="col-md-4">
                    <label for="Tel_personne" class="form-label">Tel_person</label>
                    <input type="text" class="form-control" id="Tel_personne" name="Tel_personne" required>
                </div>
                <!-- Email_personne -->
                <div class="col-md-4">
                    <label for="Email_personne" class="form-label">Email_person</label>
                    <input type="email" class="form-control" id="Email_personne" name="Email_personne" required>
                </div>
            </div>

            <!-- Fax_personne -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="Fax_personne" class="form-label">Fax_person</label>
                    <input type="text" class="form-control" id="Fax_personne" name="Fax_personne" required>
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <!-- Numero du devis -->
                <div class="col-md-4">
                    <label for="Numero_du_devis" class="form-label">Quotation Number</label>
                    <input type="text" class="form-control" id="Numero_du_devis" name="Numero_du_devis" required>
                </div>
                <div class="col-md-4">
                    <label for="Type_commande" class="form-label">Order Type</label>
                    <select class="form-select" id="Type_commande" name="Type_commande" required>
                        <option value="">Select an item</option>
                        <!-- Loop through typeDeCommandeOptions -->
                        @foreach ($typeDeCommandeOptions as $id => $libelle)
                            <option value="{{ $id }}">{{ $libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Numero de la commande -->
                <div class="col-md-4">
                    <label for="Numero_de_la_commande" class="form-label">Order Number</label>
                    <input type="text" class="form-control" id="Numero_de_la_commande"
                        name="Numero_de_la_commande" required>
                </div>
            </div>

            <div class="row mb-3">

                <!-- Date_de_la_commande -->
                <div class="col-md-4">
                    <label for="Date_de_la_commande" class="form-label">Order date</label>
                    <input type="date" class="form-control" id="Date_de_la_commande" name="Date_de_la_commande"
                        required>
                </div>
                <!-- Modalité paiement -->
                <div class="col-md-4">
                    <label for="Modalite_paiement" class="form-label">Payment Method</label>
                    <select class="form-select" id="Modalite_paiement" name="Modalite_paiement" required>
                        <option value="">Select an item</option>
                        <!-- Loop through modalitePaiementOptions -->
                        @foreach ($modalitePaiementOptions as $id => $libelle)
                            <option value="{{ $id }}">{{ $libelle }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Conditions de paiement -->
                <div class="col-md-4">
                    <label for="Conditions_de_paiement" class="form-label">Payment Conditions</label>
                    <input type="text" class="form-control" id="Conditions_de_paiement"
                        name="Conditions_de_paiement" required>
                </div>

            </div>

            <!-- More fields for Type commande, Modalité paiement, etc. -->

            <hr>
            <!-- Agence -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="Agence" class="form-label">Agency</label>
                    <select class="form-select" id="Agence" name="Agence" required>
                        <option value="">Select an item</option>
                        <!-- Loop through agenceOptions -->
                        @foreach ($agenceOptions as $id => $libelle)
                            <option value="{{ $id }}">{{ $libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Ingenieur tecnitas -->
                <div class="col-md-6">
                    <label for="Ingenieur_tecnitas" class="form-label">Tecnitas Engineer</label>
                    <input type="text" class="form-control" id="Ingenieur_tecnitas" name="Ingenieur_tecnitas"
                        required>
                </div>
            </div>

            <br>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
        <a href="/affaires" class="btn btn-warning"><i class="bi bi-skip-backward"></i> Back to Business list</a>
    </div>
</x-app-layout>

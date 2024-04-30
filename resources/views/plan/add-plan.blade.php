<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                Add a new plan
            </h2>
        </div>
    </x-slot>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add a new plan</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
        <form action="/add/plan" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="col-md-4">
                    <label for="project" class="form-label">Project</label>
                    <input type="text" class="form-control" id="project" name="projet" required>
                </div>
                <div class="col-md-4">
                    <label for="sender" class="form-label">Sender</label>
                    <input type="text" class="form-control" id="sender" name="expediteur" required>
                </div>
                <div class="col-md-4">
                    <label for="tecnicas_engineer" class="form-label">Tecnicas Engineer</label>
                    <input type="text" class="form-control" id="tecnicas_engineer" name="ingenieur_tecnitas" required>
                </div>
                <div class="col-md-4">
                    <label for="np" class="form-label">NP</label>
                    <input type="text" class="form-control" id="np" name="np" required>
                </div>
                <div class="col-md-4">
                    <label for="n_ex" class="form-label">N° Ex</label>
                    <input type="text" class="form-control" id="n_ex" name="numero_ex" required>
                </div>
                <div class="col-md-4">
                    <label for="mod" class="form-label">MOD</label>
                    <input type="text" class="form-control" id="mod" name="mod" required>
                </div>
                <div class="col-md-4">
                    <label for="bet" class="form-label">BET</label>
                    <input type="text" class="form-control" id="bet" name="bet" required>
                </div>
                <div class="col-md-4">
                    <label for="state" class="form-label">State</label>
                    <select class="form-select" id="state" name="etat_de_plan" required>
                        <option value="">Select an item</option>
                        @foreach($etatOptions as $option)

                            <option value="{{ $option->id }}">{{ $option->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="entry_receipt" class="form-label">Entry Receipt</label>
                    <input type="text" class="form-control" id="entry_receipt" name="accuse_entree" required>
                </div>
                <div class="col-md-4">
                    <label for="exit_receipt" class="form-label">Exit Receipt</label>
                    <input type="text" class="form-control" id="exit_receipt" name="accuse_sortie" required>
                </div>
                <div class="col-md-4">
                    <label for="transmission_state" class="form-label">Transmission State</label>
                    <select class="form-select" id="transmission_state" name="etat_de_transmission" required>
                        <option value="">Select an item</option>
                        @foreach($etatTransmissionOptions as $option)
                            <option value="{{ $option->id }}">{{ $option->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="transmission_date" class="form-label">Transmission Date</label>
                    <input type="date" class="form-control" id="transmission_date" name="date_transmission" required>
                </div>
                <div class="col-md-4">
                    <label for="observation" class="form-label">Observation</label>
                    <input type="text" class="form-control" id="observation" name="observation" required>
                </div>
                <div class="col-md-4">
                    <label for="coordinator" class="form-label">Coordinator</label>
                    <input type="text" class="form-control" id="coordinator" name="Coordinateur" required>
                </div>
                <div class="col-md-4">
                    <label for="architect" class="form-label">Architect</label>
                    <input type="text" class="form-control" id="architect" name="architecte" required>
                </div>
                <div class="col-md-4">
                    <label for="company" class="form-label">Company</label>
                    <input type="text" class="form-control" id="company" name="entreprise" required>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
        <a href="/plans" class="btn btn-warning"><i class="bi bi-skip-backward"></i> Back to plans list</a>    </div>
</x-app-layout>

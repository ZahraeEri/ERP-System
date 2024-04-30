<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                Add a new client
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

        <form action="/add/client" method="post">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="code" class="form-label">Code</label>
                    <input type="text" class="form-control" id="code" name="code" required>
                </div>
                <div class="col-md-6">
                    <label for="raison_sociale" class="form-label">Raison Sociale</label>
                    <input type="text" class="form-control" id="raison_sociale" name="raison_sociale" required>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>

        <a href="/clients" class="btn btn-warning"><i class="bi bi-skip-backward"></i> Back to clients list</a>
    </div>
</x-app-layout>

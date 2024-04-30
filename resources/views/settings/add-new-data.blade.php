<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            {{-- <h2 class="text-xl font-semibold leading-tight">
                {{ __('Users list') }}
            </h2> --}}
            {{-- <x-button target="_blank" href="https://github.com/kamona-wd/kui-laravel-breeze" variant="black"
                class="justify-center max-w-xs gap-2">
                <x-icons.github class="w-6 mb-2 font-medium leading-tight text-base" aria-hidden="true" />
                <span>Star on Github</span>
            </x-button> --}}

        </div>
    </x-slot>
    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add a new user</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="container mx-auto sm:px-4 mt-3">
    <h2>Add a new user</h2>
    <x-modal2/>
    <!-- Your existing code for status and errors -->

    {{-- <form id="addUserForm" action="/add/treatment" method="post" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="label" class="form-label">Label</label>
            <input type="text" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" id="label" name="label" required>
        </div>
        <div id="valueInput" class="mb-3" style="display: none;">
            <label for="value" class="form-label">Value</label>
            <input type="text" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" id="value" name="value" required>
        </div>
        <button type="submit" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-blue-600 text-white hover:bg-blue-600"><i class="bi bi-person-plus"></i></button>
    </form>
    <a href="/settings" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-orange-400 text-black hover:bg-orange-500"><i class="bi bi-skip-backward"></i> Back</a> --}}
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tableSelect = document.getElementById('tableSelect');
        var valueInput = document.getElementById('valueInput');

        tableSelect.addEventListener('change', function () {
            var tableName = this.value;
            if (tableName === 'tva') {
                valueInput.style.display = 'block';
            } else {
                valueInput.style.display = 'none';
            }
        });
    });
</script>
</body>
</html>
</x-app-layout>

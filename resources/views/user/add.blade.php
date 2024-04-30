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

    {{-- <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        {{ __("You're logged in!")  }}
    </div> --}}
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
    @if (session('status'))
    <div class="relative px-3 py-3 mb-4 border rounded bg-green-200 border-green-300 text-green-800">
        {{ session('status') }}
    </div>
     @endif
    <ul>
        @foreach ($errors->all( ) as $error)
            <li class="relative px-3 py-3 mb-4 border rounded bg-red-200 border-red-300 text-red-800">{{$error}}</li>
        @endforeach
    </ul>

    <form action="/add/treatment" method="post" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
            <label for="name" class="form-label">First name</label>
            <input type="text" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" id="name" name="name" required>
            </div>
            <div class="col-md-6">
            <label for="name" class="form-label">Last name</label>
            <input type="text" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" id="lastname" name="lastname" required>
            </div>
        </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" id="password" name="password" required>
      </div>
      <div class="mb-3">
        <label for="photo" class="form-label">Profile Picture</label>
        <input type="file" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" id="photo" name="photo" >
      </div>
      <button type="submit" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-blue-600 text-white hover:bg-blue-600"><i class="bi bi-person-plus"></i></button>
    </form>
    <a href="/user" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-orange-400 text-black hover:bg-orange-500"><i class="bi bi-skip-backward"></i> Back to users list</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jY38PBHQiwNkBvQhQbCc9VwIkT1pe" crossorigin="anonymous"></script>
</body>
</html>
</x-app-layout>

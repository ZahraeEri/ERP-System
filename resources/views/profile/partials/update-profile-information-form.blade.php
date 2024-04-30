<section>
    <header>
        <h2 class="text-lg font-medium">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information, photo, and email address.") }}
        </p>
    </header>

    <form
        method="post"
        action="{{ route('profile.update') }}"
        class="mt-6 space-y-6"
        enctype="multipart/form-data"
    >
        @csrf
        @method('patch')

        <!-- Photo upload section -->
        <div class="space-y-2">
            <x-form.label for="photo" :value="__('Update Photo')" />

            <!-- Display the current profile picture if it exists -->
            @if($user->photo)
                <img src="{{ asset('assets/profile_pictures/' . $user->photo) }}" alt="Current Photo" class="mb-2 w-24 h-24 object-cover rounded-full">
            @endif

            <x-form.input
                id="photo"
                name="photo"
                type="file"
                class="block w-full"
            />

            <x-form.error :messages="$errors->get('photo')" />
        </div>

        <div class="space-y-2">
            <x-form.label for="name" :value="__('First Name')" />

            <x-form.input
                id="name"
                name="name"
                type="text"
                class="block w-full"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />

            <x-form.error :messages="$errors->get('name')" />
        </div>

        <div class="space-y-2">
            <x-form.label for="lastname" :value="__('Last Name')" />

            <x-form.input
                id="lastname"
                name="lastname"
                type="text"
                class="block w-full"
                :value="old('lastname', $user->lastname)"
                required
                autocomplete="lastname"
            />

            <x-form.error :messages="$errors->get('lastname')" />
        </div>

        <div class="space-y-2">
            <x-form.label for="email" :value="__('Email')" />

            <x-form.input
                id="email"
                name="email"
                type="email"
                class="block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="email"
            />

            <x-form.error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-300">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500  dark:text-gray-400 dark:hover:text-gray-200 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-button>
                {{ __('Save') }}
            </x-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
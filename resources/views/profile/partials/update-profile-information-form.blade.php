<section>
    <header>
        @extends('home.layout.head')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        @section('title') Profile @endsection
        @include('sweetalert::alert')
        @include('home.layout.header')

        <section class="inner_page_head">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="full">
                            <h3>{{ __('Profile Information') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <p class="text-center text-gray-500 mt-3">
            {{ __("Update your account's profile information and email address.") }}
        </p>


        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif
    </header>

    <div class="container mt-5">
        <div class="scrollable-container">
            <div class="col-md-12">
                @if ($errors->any())
                    <ul class="alert alert-warning">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="mt-4 space-y-4" id="profileForm">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="form-control" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="form-control" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-3">
                                <p class="text-sm text-gray-800 dark:text-gray-200">
                                    {{ __('Your email address is unverified.') }}
                                    <button form="send-verification" class="btn btn-link p-0 text-decoration-none text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 text-sm text-success">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary" id="saveButton" disabled>
                            {{ __('Save') }}
                        </button>
                    </div>

                    @if (session('status') === 'profile-updated')
                        <p class="mt-2 text-sm text-success">
                            {{ __('Saved.') }}
                        </p>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('profileForm');
            const saveButton = document.getElementById('saveButton');

            form.addEventListener('input', function() {
                // Check if all required fields are filled
                const isValid = form.checkValidity();
                saveButton.disabled = !isValid;
            });
        });
    </script>
</section>

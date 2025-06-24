<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-base-200">
        <div class="w-full max-w-4xl mt-6 mb-6 mx-auto">
            <div class="card lg:card-side bg-base-100 shadow-2xl">

                {{-- LADO ESQUERDO: MENSAGEM DE BOAS-VINDAS --}}
                <div
                    class="card-body bg-primary text-primary-content rounded-t-2xl lg:rounded-l-2xl lg:rounded-r-none flex flex-col justify-center items-center p-12">
                    <a href="/" class="mb-8">
                        {{-- Você pode colocar sua logo aqui --}}
                        <h1 class="text-4xl font-bold">Anfitrião Pro</h1>
                    </a>
                    <div class="text-center">
                        <h2 class="text-2xl font-bold mb-2">Bem-vindo de volta!</h2>
                        <p>Acesse sua conta para gerenciar suas reservas, calendários e finanças.</p>
                    </div>
                </div>

                {{-- LADO DIREITO: FORMULÁRIO DE LOGIN --}}
                <div class="card-body p-8 md:p-12">
                    <h2 class="card-title text-3xl mb-6">Fazer Login</h2>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="form-control">
                            <label class="label" for="email">
                                <span class="label-text">Email</span>
                            </label>
                            <input id="email" type="email" name="email" :value="old('email')" required
                                autofocus autocomplete="username" class="input input-bordered w-full" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Senha -->
                        <div class="form-control mt-4">
                            <label class="label" for="password">
                                <span class="label-text">Senha</span>
                            </label>
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password" class="input input-bordered w-full" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Lembrar-me e Esqueceu a senha -->
                        <div class="flex items-center justify-between mt-4 text-sm">
                            <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                                <input id="remember_me" type="checkbox" class="checkbox checkbox-primary"
                                    name="remember">
                                <span>Lembrar-me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="link link-hover" href="{{ route('password.request') }}">
                                    {{ __('Esqueceu sua senha?') }}
                                </a>
                            @endif
                        </div>

                        <div class="form-control mt-8">
                            <button type="submit" class="btn btn-primary w-full">
                                {{ __('Entrar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

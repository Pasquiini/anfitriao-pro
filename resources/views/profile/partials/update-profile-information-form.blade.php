<section>
    <header>
        <h2 class="text-lg font-medium text-base-content">
            {{ __('Informações do Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-base-content/70">
            {{ __("Atualize as informações de perfil e o endereço de e-mail da sua conta.") }}
        </p>
    </header>

    {{-- Este formulário oculto é usado apenas para reenviar a verificação de e-mail. Vamos mantê-lo. --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Campo Nome --}}
        <div class="form-control w-full">
            <label class="label" for="name">
                <span class="label-text">{{ __('Nome') }}</span>
            </label>
            <input id="name" name="name" type="text" class="input input-bordered w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Campo Email --}}
        <div class="form-control w-full">
            <label class="label" for="email">
                <span class="label-text">{{ __('Email') }}</span>
            </label>
            <input id="email" name="email" type="email" class="input input-bordered w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- Bloco de Verificação de Email --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                {{-- Vamos usar um componente de alerta do DaisyUI para destacar esta mensagem --}}
                <div role="alert" class="alert alert-warning mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <div>
                        <p class="text-sm">
                            {{ __('Seu endereço de e-mail não foi verificado.') }}
                        </p>
                        <button form="send-verification" class="link link-hover text-sm font-semibold">
                            {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                        </button>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-sm font-bold">{{ __('Um novo link de verificação foi enviado.') }}</p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Botão de Salvar e Mensagem de Sucesso --}}
        <div class="flex items-center gap-4">
            <button class="btn btn-primary">{{ __('Salvar') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-success"
                >{{ __('Salvo.') }}</p>
            @endif
        </div>
    </form>
</section>

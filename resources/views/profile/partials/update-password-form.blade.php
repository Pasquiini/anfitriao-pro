<section>
    <header>
        <h2 class="text-lg font-medium text-base-content">
            {{ __('Alterar Senha') }}
        </h2>

        <p class="mt-1 text-sm text-base-content/70">
            {{ __('Garanta que sua conta esteja usando uma senha longa e aleatória para se manter segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Campo Senha Atual --}}
        <div class="form-control w-full">
            <label class="label" for="update_password_current_password">
                <span class="label-text">{{ __('Senha Atual') }}</span>
            </label>
            <input id="update_password_current_password" name="current_password" type="password" class="input input-bordered w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- Campo Nova Senha --}}
        <div class="form-control w-full">
            <label class="label" for="update_password_password">
                <span class="label-text">{{ __('Nova Senha') }}</span>
            </label>
            <input id="update_password_password" name="password" type="password" class="input input-bordered w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Campo Confirmar Nova Senha --}}
        <div class="form-control w-full">
            <label class="label" for="update_password_password_confirmation">
                <span class="label-text">{{ __('Confirme a Senha') }}</span>
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="input input-bordered w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Botão de Salvar e Mensagem de Sucesso --}}
        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>

            {{-- A lógica de exibição da mensagem de sucesso do Breeze/Alpine.js é ótima.
                 Vamos apenas ajustar a cor do texto para usar as classes do DaisyUI. --}}
            @if (session('status') === 'password-updated')
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

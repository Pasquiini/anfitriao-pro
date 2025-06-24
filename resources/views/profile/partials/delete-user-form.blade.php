<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-base-content">
            {{ __('Deletar Conta') }}
        </h2>

        <p class="mt-1 text-sm text-base-content/70">
            {{ __('Uma vez que sua conta for deletada, todos os seus recursos e dados serão permanentemente apagados. Antes de deletar sua conta, por favor, baixe quaisquer dados ou informações que você deseja reter.') }}
        </p>
    </header>

    {{-- O botão que abre o modal, agora com classes DaisyUI --}}
    <button
        class="btn btn-error"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Deletar Conta') }}</button>

    {{-- Mantemos o componente x-modal do Breeze, que controla a lógica de abrir/fechar,
         mas estilizamos todo o conteúdo dele com DaisyUI. --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-base-content">
                {{ __('Você tem certeza que quer deletar sua conta?') }}
            </h2>

            <p class="mt-2 text-sm text-base-content/70">
                {{ __('Uma vez que sua conta for deletada, todos os seus recursos e dados serão permanentemente apagados. Por favor, digite sua senha para confirmar que você gostaria de deletar permanentemente sua conta.') }}
            </p>

            {{-- Campo de senha com classes DaisyUI --}}
            <div class="form-control mt-6">
                <label class="label sr-only" for="password">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="input input-bordered w-full"
                    placeholder="{{ __('Senha') }}"
                />
                {{-- O componente de erro do Breeze continua funcionando perfeitamente --}}
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            {{-- Botões de ação com classes DaisyUI --}}
            <div class="mt-6 flex justify-end gap-3">
                {{-- Botão Cancelar --}}
                <button type="button" x-on:click="$dispatch('close')" class="btn btn-ghost">
                    {{ __('Cancelar') }}
                </button>

                {{-- Botão Deletar --}}
                <button type="submit" class="btn btn-error">
                    {{ __('Deletar Conta') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>

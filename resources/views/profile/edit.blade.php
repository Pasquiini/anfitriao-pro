<x-app-layout>
    {{-- O cabeçalho da página, agora mais simples e direto --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Meu Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- O Alpine.js irá controlar qual aba está ativa. Começamos com 'profile'. --}}
            <div x-data="{ activeTab: 'profile' }" class="card w-full bg-base-100 shadow-xl border">
                <div class="card-body">
                    {{-- As Abas (TABS) do DaisyUI --}}
                    <div class="tabs tabs-bordered">
                        <a class="tab tab-bordered"
                           :class="{ 'tab-active': activeTab === 'profile' }"
                           @click.prevent="activeTab = 'profile'">
                           Informações do Perfil
                        </a>
                        <a class="tab tab-bordered"
                           :class="{ 'tab-active': activeTab === 'password' }"
                           @click.prevent="activeTab = 'password'">
                           Alterar Senha
                        </a>
                        {{-- <a class="tab tab-bordered"
                           :class="{ 'tab-active': activeTab === 'delete' }"
                           @click.prevent="activeTab = 'delete'">
                           Deletar Conta
                        </a> --}}
                    </div>

                    {{-- Conteúdo de cada aba --}}
                    <div class="pt-8">
                        {{-- Conteúdo da Aba 1: Informações do Perfil --}}
                        <div x-show="activeTab === 'profile'" class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>

                        {{-- Conteúdo da Aba 2: Alterar Senha --}}
                        <div x-show="activeTab === 'password'" class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>

                        {{-- Conteúdo da Aba 3: Deletar Conta --}}
                        {{-- <div x-show="activeTab === 'delete'" class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div> --}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

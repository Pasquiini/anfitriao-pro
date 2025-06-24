<div class="navbar bg-base-100 shadow-md px-4 sm:px-6 lg:px-8">
    {{-- SEÇÃO DA ESQUERDA (LOGO) --}}
    <div class="navbar-start">
        <a href="{{ route('dashboard') }}" class="btn btn-ghost text-xl normal-case">
            <span class="ml-2 hidden sm:inline">{{ config('app.name', 'Anfitrião Pro') }}</span>
        </a>
    </div>

    {{-- SEÇÃO CENTRAL (LINKS PRINCIPAIS PARA DESKTOP) --}}
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('calendario') }}" class="{{ request()->routeIs('calendario') ? 'active' : '' }}">
                    Calendário
                </a>
            </li>
            <li>
                <a href="{{ route('imoveis.index') }}" class="{{ request()->routeIs('imoveis.*') ? 'active' : '' }}">
                    Meus Imóveis
                </a>
            </li>
        </ul>
    </div>

    {{-- SEÇÃO DA DIREITA (DROPDOWN DO USUÁRIO E MENU MOBILE) --}}
    <div class="navbar-end">
        {{-- Dropdown do Usuário para Telas Grandes --}}
        <div class="hidden sm:flex items-center">
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost">
                    <div>{{ Auth::user()->name }}</div>
                    <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </label>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="{{ route('profile.edit') }}">Meu Perfil</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Sair
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Menu Hamburger para Telas Pequenas --}}
        <div class="dropdown dropdown-end sm:hidden">
            <label tabindex="0" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </label>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                {{-- Links do menu mobile --}}
                <li><a href="{{ route('dashboard') }}"
                        class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('calendario') }}"
                        class="{{ request()->routeIs('calendario') ? 'active' : '' }}">Calendário</a></li>
                <li><a href="{{ route('imoveis.index') }}"
                        class="{{ request()->routeIs('imoveis.*') ? 'active' : '' }}">Meus Imóveis</a></li>
                <div class="divider my-1"></div>
                <li><a href="{{ route('profile.edit') }}">Meu Perfil</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Sair
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

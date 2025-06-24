<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Anfitrião Pro - O seu sistema de gestão de reservas</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- DaisyUI -->
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />

        <style>
            /* Pequeno ajuste para garantir que a fonte Inter seja aplicada */
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    <body class="bg-base-100 antialiased">

        <!-- Header / Navbar -->
        <header class="bg-base-100/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
            <div class="navbar max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="navbar-start">
                    <div class="dropdown">
                        <label tabindex="0" class="btn btn-ghost lg:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
                        </label>
                        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                            <li><a href="#funcionalidades">Funcionalidades</a></li>
                            <li><a href="#precos">Preços</a></li>
                        </ul>
                    </div>
                    <a class="btn btn-ghost text-xl font-bold">Anfitrião Pro</a>
                </div>
                <div class="navbar-center hidden lg:flex">
                    <ul class="menu menu-horizontal px-1">
                        <li><a href="#funcionalidades">Funcionalidades</a></li>
                        <li><a href="#precos">Preços</a></li>
                    </ul>
                </div>
                <div class="navbar-end">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline btn-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-ghost mr-2">Fazer Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">Contratar</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            <!-- Hero Section -->
            <section class="hero min-h-[80vh] bg-base-200">
                <div class="hero-content text-center">
                    <div class="max-w-3xl">
                        <h1 class="text-5xl md:text-7xl font-bold">Diga adeus ao overbooking.</h1>
                        <p class="py-6 text-lg">Anfitrião Pro é o sistema simples e poderoso que você precisa para gerenciar suas reservas, evitar agendamentos duplicados e profissionalizar a gestão dos seus imóveis de temporada.</p>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Começar Agora por R$ 29/mês</a>
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-lg">Já tenho conta</a>
                    </div>
                </div>
            </section>

            <!-- Funcionalidades (Features) Section -->
            <section id="funcionalidades" class="py-20 bg-base-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="text-4xl font-bold">Tudo que você precisa, sem complicação.</h2>
                    <p class="mt-4 text-lg text-base-content/70">Foco nas ferramentas que resolvem seus problemas diários.</p>
                    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-12">
                        <!-- Feature 1 -->
                        <div class="flex flex-col items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary text-primary-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            </div>
                            <h3 class="mt-5 text-xl font-bold">Calendário Centralizado</h3>
                            <p class="mt-2 text-base text-base-content/70">Visualize todas as suas reservas, de todos os seus imóveis, em um único calendário interativo. Nunca mais se perca nas datas.</p>
                        </div>
                        <!-- Feature 2 -->
                        <div class="flex flex-col items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary text-primary-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01" /></svg>
                                </div>
                            </div>
                            <h3 class="mt-5 text-xl font-bold">Controle Financeiro</h3>
                            <p class="mt-2 text-base text-base-content/70">Registre o valor de cada reserva e tenha uma previsão clara do seu faturamento. Transforme sua agenda em uma ferramenta de negócio.</p>
                        </div>
                        <!-- Feature 3 -->
                        <div class="flex flex-col items-center">
                             <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary text-primary-content">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                </div>
                            </div>
                            <h3 class="mt-5 text-xl font-bold">Zero Overbooking</h3>
                            <p class="mt-2 text-base text-base-content/70">Nossa trava de segurança impede que você agende duas reservas para o mesmo período no mesmo imóvel. Sua tranquilidade garantida.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Pricing Section -->
            <section id="precos" class="py-20 bg-base-200">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="text-4xl font-bold">Um preço simples e justo.</h2>
                    <p class="mt-4 text-lg text-base-content/70">Sem pegadinhas, sem taxas escondidas. Todas as funcionalidades por um valor fixo.</p>
                    <div class="mt-12 flex justify-center">
                        <div class="card w-full max-w-sm bg-base-100 shadow-2xl">
                            <div class="card-body">
                                <h3 class="card-title text-2xl mx-auto">Plano Profissional</h3>
                                <p class="text-center text-5xl font-bold my-6">
                                    R$ 29<span class="text-xl font-normal">/mês</span>
                                </p>
                                <ul class="space-y-2 text-left mb-8">
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Imóveis ilimitados</li>
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Reservas ilimitadas</li>
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Calendário Visual</li>
                                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Suporte via WhatsApp</li>
                                </ul>
                                <div class="card-actions justify-end">
                                    <a href="{{ route('register') }}" class="btn btn-primary w-full">Quero contratar agora!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="footer footer-center p-10 bg-base-200 text-base-content">
            <aside>
                <p>Copyright © {{ date('Y') }} - Todos os direitos reservados por Anfitrião Pro</p>
                <p>Desenvolvido para simplificar a vida dos anfitriões de Lagoa Santa - GO</p>
            </aside>
        </footer>

    </body>
</html>

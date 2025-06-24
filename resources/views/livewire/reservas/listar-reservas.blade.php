<div class="p-4 sm:p-6 lg:p-8">
    {{-- Alerta de sucesso (código existente) --}}
    @if (session()->has('sucesso'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" role="alert" class="alert alert-success">
            <span>{{ session('sucesso') }}</span>
        </div>
    @endif

    {{-- CABEÇALHO DA PÁGINA --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Reservas para: {{ $imovel->nome }}</h1>
        <p class="text-base-content/60">{{ $imovel->endereco }}</p>
    </div>

    {{-- BARRA DE FERRAMENTAS E FILTROS --}}
    <div class="card w-full bg-base-100 shadow-md border mb-6">
        <div class="card-body flex-col md:flex-row items-center justify-between gap-4">
            <div class="form-control w-full md:w-1/2">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por nome do hóspede..." class="input input-bordered w-full" />
            </div>
            <div class="form-control w-full md:w-1/4">
                <select wire:model.live="filterStatus" class="select select-bordered">
                    <option value="">Todos os Status</option>
                    <option value="confirmada">Confirmadas</option>
                    <option value="cancelada">Canceladas</option>
                    <option value="bloqueado">Bloqueados</option>
                </select>
            </div>
            <div class="w-full md:w-auto flex justify-end">
                <a href="{{ route('reservas.create', $imovel) }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    Nova Reserva
                </a>
            </div>
        </div>
    </div>

    {{-- TABELA DE RESERVAS --}}
    <div class="card w-full bg-base-100 shadow-xl border">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th><a href="#" wire:click.prevent="setSortBy('data_inicio')">Check-in</a></th>
                            <th><a href="#" wire:click.prevent="setSortBy('data_fim')">Check-out</a></th>
                            <th><a href="#" wire:click.prevent="setSortBy('nome_hospede')">Hóspede</a></th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reservas as $reserva)
                            <tr class="hover">
                                <td class="font-bold">{{ \Carbon\Carbon::parse($reserva->data_inicio)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->data_fim)->format('d/m/Y') }}</td>
                                <td>{{ $reserva->nome_hospede }}</td>
                                <td>
                                    @if($reserva->valor)
                                        R$ {{ number_format($reserva->valor, 2, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $reserva->status === 'confirmada' ? 'badge-success' : '' }} {{ $reserva->status === 'cancelada' ? 'badge-ghost' : '' }} {{ $reserva->status === 'bloqueado' ? 'badge-warning' : '' }} badge-outline">
                                        {{ $reserva->status }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    {{-- Adicionar botões de editar/cancelar aqui se desejar --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-8">
                                    <p class="font-semibold">Nenhuma reserva encontrada com os filtros atuais.</p>
                                    <button wire:click="clearFilters" class="btn btn-ghost btn-sm mt-2">Limpar Filtros</button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- LINKS DA PAGINAÇÃO --}}
    <div class="mt-8">
        {{ $reservas->links() }}
    </div>
</div>

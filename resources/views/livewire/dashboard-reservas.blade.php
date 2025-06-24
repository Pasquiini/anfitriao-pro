<div class="p-4 sm:p-6 lg:p-8">
    {{-- Alerta de Sucesso --}}
    @if (session()->has('sucesso'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" role="alert" class="alert alert-success mb-6">
            <span>{{ session('sucesso') }}</span>
        </div>
    @endif

    {{-- 1. CARDS DE ESTATÍSTICAS (KPIs) --}}
    <div class="stats shadow w-full mb-8">
        <div class="stat">
            <div class="stat-figure text-secondary"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1m0-16v1" />
                </svg></div>
            <div class="stat-title">Check-ins Hoje</div>
            <div class="stat-value">{{ $checkinsHoje }}</div>
        </div>
        <div class="stat">
            <div class="stat-figure text-secondary"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 8l4 4m0 0l-4 4m4-4H3m5-4v1m0 16v-1" />
                </svg></div>
            <div class="stat-title">Check-outs Hoje</div>
            <div class="stat-value">{{ $checkoutsHoje }}</div>
        </div>
        <div class="stat">
            <div class="stat-figure text-primary"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01" />
                </svg></div>
            <div class="stat-title">Receita do Mês Atual</div>
            <div class="stat-value">R$ {{ number_format($faturamentoMes, 2, ',', '.') }}</div>
        </div>
    </div>

    {{-- 2. BARRA DE FILTROS --}}
    <div class="card w-full bg-base-100 shadow-md border mb-6">
        <div class="card-body grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por hóspede..."
                class="input input-bordered w-full lg:col-span-2">
            <select wire:model.live="filterImovelId" class="select select-bordered w-full">
                <option value="">Todos Imóveis</option>
                @foreach ($meusImoveis as $imovel)
                    <option value="{{ $imovel->id }}">{{ $imovel->nome }}</option>
                @endforeach
            </select>
            <select wire:model.live="filterStatus" class="select select-bordered w-full">
                <option value="">Todos Status</option>
                <option value="confirmada">Confirmadas</option>
                <option value="cancelada">Canceladas</option>
                <option value="bloqueado">Bloqueados</option>
            </select>
            <input type="date" wire:model.live="filterDataInicio" class="input input-bordered w-full"
                title="Data de início do período">
            <input type="date" wire:model.live="filterDataFim" class="input input-bordered w-full"
                title="Data de fim do período">
            <button wire:click="clearFilters" class="btn btn-ghost">Limpar Filtros</button>
            <div class="flex justify-end gap-2">
                <button wire:click="$set('showBloqueioModal', true)" class="btn btn-secondary">Bloquear</button>
                <button wire:click="$set('showNovaReservaModal', true)" class="btn btn-primary">Nova Reserva</button>
            </div>
        </div>
    </div>

    {{-- 3. TABELA MELHORADA --}}
    <div class="card w-full bg-base-100 shadow-xl border">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th><a href="#" wire:click.prevent="setSortBy('data_inicio')">Check-in</a></th>
                            <th>Nº Noites</th>
                            <th>Imóvel</th>
                            <th>Hóspede</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reservas as $reserva)
                            <tr class="hover">
                                <td>
                                    <div class="font-bold">
                                        {{ \Carbon\Carbon::parse($reserva->data_inicio)->format('d/m/Y') }}</div>
                                    <div class="text-sm opacity-50">
                                        {{ \Carbon\Carbon::parse($reserva->data_fim)->format('d/m/Y') }}</div>
                                </td>
                                <td>{{ abs(\Carbon\Carbon::parse($reserva->data_fim)->diffInDays(\Carbon\Carbon::parse($reserva->data_inicio))) }}
                                </td>
                                <td><a href="{{ route('imoveis.detalhes', $reserva->imovel) }}"
                                        class="link link-hover">{{ $reserva->imovel->nome }}</a></td>
                                <td>{{ $reserva->nome_hospede }}</td>
                                <td><span
                                        class="badge {{ $reserva->status === 'confirmada' ? 'badge-success' : '' }}{{ $reserva->status === 'cancelada' ? 'badge-error' : '' }}{{ $reserva->status === 'bloqueado' ? 'badge-warning' : '' }} badge-outline">{{ $reserva->status }}</span>
                                </td>
                                <td class="text-right space-x-1">
                                    <a href="{{ route('reservas.edit', ['reservaId' => $reserva->id]) }}"
                                        class="btn btn-ghost btn-xs">editar</a>
                                    @if ($reserva->status !== 'cancelada')
                                        <button wire:click="abrirModalCancelamento({{ $reserva->id }})"
                                            class="btn btn-error btn-outline btn-xs">
                                            cancelar
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-8">
                                    <p class="font-semibold">Nenhuma reserva encontrada com os filtros atuais.</p>
                                    <button wire:click="clearFilters" class="btn btn-ghost btn-sm mt-2">Limpar
                                        Filtros</button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 4. LINKS DE PAGINAÇÃO --}}
    <div class="mt-8">{{ $reservas->links() }}</div>
    @if ($showNovaReservaModal)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Criar Nova Reserva</h3>
                <p class="py-4">Para qual imóvel você deseja criar a reserva?</p>

                {{-- Dropdown para selecionar o imóvel --}}
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Selecione o Imóvel</span>
                    </label>
                    <select wire:model.live="imovelSelecionadoId" class="select select-bordered">
                        <option value="">-- Escolha um imóvel --</option>
                        @foreach ($meusImoveis as $imovel)
                            <option value="{{ $imovel->id }}">{{ $imovel->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-action">
                    <button wire:click="fecharModal" class="btn btn-ghost">Cancelar</button>
                    @if ($imovelSelecionadoId)
                        <a href="{{ route('reservas.create', ['imovelId' => $imovelSelecionadoId]) }}"
                            class="btn btn-primary">Prosseguir</a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if ($showBloqueioModal)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Bloquear Período</h3>
                <form wire:submit.prevent="salvarBloqueio" class="space-y-4 py-4">
                    {{-- Seleção de Imóvel --}}
                    <select wire:model.live="imovelBloqueioId" class="select select-bordered w-full">
                        <option value="">-- Selecione um imóvel --</option>
                        @foreach ($meusImoveis as $imovel)
                            <option value="{{ $imovel->id }}">{{ $imovel->nome }}</option>
                        @endforeach
                    </select>
                    @error('imovelBloqueioId')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                    {{-- Datas --}}
                    <div class="grid grid-cols-2 gap-4">
                        <input type="date" wire:model.defer="dataInicioBloqueio"
                            class="input input-bordered w-full">
                        <input type="date" wire:model.defer="dataFimBloqueio" class="input input-bordered w-full">
                    </div>
                    @error('dataInicioBloqueio')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                    {{-- Motivo --}}
                    <input type="text" wire:model.defer="motivoBloqueio" placeholder="Motivo (ex: Manutenção)"
                        class="input input-bordered w-full">
                    @error('motivoBloqueio')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                    <div class="modal-action">
                        <button type="button" wire:click="$set('showBloqueioModal', false)"
                            class="btn btn-ghost">Cancelar</button>
                        <button type="submit" class="btn btn-accent">Salvar Bloqueio</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    @if ($reservaParaCancelarId)
<div class="modal modal-open">
    <div class="modal-box">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-error mx-auto shrink-0 h-16 w-16" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        <h3 class="font-bold text-lg text-center mt-4">Confirmar Cancelamento</h3>
        <p class="py-4 text-center">Você tem certeza que deseja cancelar esta reserva? Esta ação não pode ser desfeita.</p>
        <div class="modal-action justify-center gap-4">
            <button wire:click="fecharModalCancelamento" class="btn btn-ghost">Voltar</button>
            <button wire:click="cancelarReserva({{ $reservaParaCancelarId }})" class="btn btn-error">Sim, cancelar reserva</button>
        </div>
    </div>
</div>
@endif
</div>

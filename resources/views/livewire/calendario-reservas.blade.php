<div>
    {{-- BARRA DE FILTROS SUPERIOR --}}
    <div class="p-4 sm:p-6 lg:p-8 pt-6 pb-2">
        <div class="form-control w-full max-w-xs">
            <label class="label"><span class="label-text">Filtrar por Imóvel</span></label>
            <select wire:model.live="imovelFiltroId" class="select select-bordered">
                <option value="">Todos os Imóveis</option>
                @foreach ($meusImoveis as $imovel)
                    <option value="{{ $imovel->id }}">{{ $imovel->nome }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Layout principal em grade --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-4 sm:p-6 lg:p-8 pt-4">

        {{-- COLUNA 1: O CALENDÁRIO --}}
        <div class="lg:col-span-2">
            <div class="card w-full bg-base-100 shadow-xl border">
                <div class="card-body">
                    <div id="calendario" wire:ignore></div>
                </div>
            </div>
        </div>

        {{-- COLUNA 2: SIDEBAR DE INFORMAÇÕES --}}
        <div class="lg:col-span-1 space-y-8">
            {{-- Card Próximos Check-ins --}}
            <div class="card w-full bg-base-100 shadow-xl border">
                <div class="card-body">
                    <h2 class="card-title mb-4">Próximos Check-ins (7 dias)</h2>
                    <div class="space-y-4">
                        @forelse ($proximosCheckins as $reserva)
                            <div class="border-l-4 border-success pl-4">
                                <p class="font-bold">{{ \Carbon\Carbon::parse($reserva->data_inicio)->format('d/m/Y') }}
                                    - {{ $reserva->nome_hospede }}</p>
                                <p class="text-sm text-base-content/70">{{ $reserva->imovel->nome }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-base-content/70">Nenhum check-in agendado.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Card Próximos Check-outs --}}
            <div class="card w-full bg-base-100 shadow-xl border">
                <div class="card-body">
                    <h2 class="card-title mb-4">Próximos Check-outs (7 dias)</h2>
                    <div class="space-y-4">
                        @forelse ($proximosCheckouts as $reserva)
                            <div class="border-l-4 border-error pl-4">
                                <p class="font-bold">{{ \Carbon\Carbon::parse($reserva->data_fim)->format('d/m/Y') }} -
                                    {{ $reserva->nome_hospede }}</p>
                                <p class="text-sm text-base-content/70">{{ $reserva->imovel->nome }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-base-content/70">Nenhum check-out agendado.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DE DETALHES DA RESERVA --}}
    @if ($reservaSelecionada)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Detalhes da Reserva</h3>
                <div class="py-4 space-y-2">
                    <p><strong>Imóvel:</strong> {{ $reservaSelecionada->imovel->nome }}</p>
                    <p><strong>Hóspede:</strong> {{ $reservaSelecionada->nome_hospede }}</p>
                    <p><strong>Contato:</strong> {{ $reservaSelecionada->contato_hospede }}</p>
                    <p><strong>Check-in:</strong>
                        {{ \Carbon\Carbon::parse($reservaSelecionada->data_inicio)->format('d/m/Y') }}</p>
                    <p><strong>Check-out:</strong>
                        {{ \Carbon\Carbon::parse($reservaSelecionada->data_fim)->format('d/m/Y') }}</p>
                    <p><strong>Nº de Hóspedes:</strong> {{ $reservaSelecionada->numero_hospedes ?? 'N/A' }}</p>
                    <p><strong>Valor:</strong> R$ {{ number_format($reservaSelecionada->valor ?? 0, 2, ',', '.') }}</p>
                    @if ($reservaSelecionada->observacoes)
                        <p><strong>Observações:</strong> {{ $reservaSelecionada->observacoes }}</p>
                    @endif
                </div>
                <div class="modal-action">
                    <button wire:click="fecharModalDetalhes" class="btn">Fechar</button>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:navigated', function() {
            var calendarEl = document.getElementById('calendario');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },

                buttonText: {
                    today: 'Hoje',
                    month: 'Mês',
                    week: 'Semana',
                    list: 'Lista'
                },
                events: @json($eventos),

                // NOVA CONFIGURAÇÃO PARA O CLIQUE
                eventClick: function(info) {
                    // Previne o comportamento padrão do navegador
                    info.jsEvent.preventDefault();
                    // Chama o método do Livewire para mostrar os detalhes do evento clicado
                    @this.call('verDetalhesReserva', info.event.id);
                }
            });
            calendar.render();

            // Ouve por atualizações do Livewire para redesenhar o calendário
            @this.on('refreshCalendar', () => {
                calendar.refetchEvents();
            });
        });
    </script>
@endpush

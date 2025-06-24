<div class="p-4 sm:p-6 lg:p-8">
    <div class="card w-full bg-base-100 shadow-xl border">
        <div class="card-body">
            <h2 class="card-title text-2xl mb-2">
                {{ $reserva->exists ? 'Editar Reserva' : 'Adicionar Nova Reserva' }}
            </h2>
            <p class="text-base-content/70 mb-6 border-b border-base-300 pb-4">
                Para o imóvel: <span class="font-semibold">{{ $imovel->nome }}</span>
            </p>

            <form wire:submit.prevent="salvarReserva">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">

                    {{-- DADOS DA RESERVA --}}
                    <h3 class="md:col-span-2 text-lg font-medium text-primary">Datas</h3>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Data de Check-in</span></label>
                        <input type="date" wire:model.defer="data_inicio" class="input input-bordered w-full" />
                        @error('data_inicio') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Data de Check-out</span></label>
                        <input type="date" wire:model.defer="data_fim" class="input input-bordered w-full" />
                        @error('data_fim') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="divider md:col-span-2 my-4"></div>

                    {{-- DADOS DO HÓSPEDE --}}
                    <h3 class="md:col-span-2 text-lg font-medium text-primary">Hóspede</h3>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Nome do Hóspede</span></label>
                        <input type="text" wire:model.defer="nome_hospede" placeholder="Nome completo do responsável" class="input input-bordered w-full" />
                        @error('nome_hospede') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Contato (Telefone/Email)</span></label>
                        <input type="text" wire:model.defer="contato_hospede" placeholder="Principal forma de contato" class="input input-bordered w-full" />
                        @error('contato_hospede') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Número de Hóspedes</span></label>
                        <input type="number" wire:model.defer="numero_hospedes" placeholder="Total de pessoas" class="input input-bordered w-full" />
                        @error('numero_hospedes') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="divider md:col-span-2 my-4"></div>

                    {{-- DADOS FINANCEIROS E OBSERVAÇÕES --}}
                    <h3 class="md:col-span-2 text-lg font-medium text-primary">Detalhes Adicionais</h3>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Valor da Reserva (R$)</span></label>
                        <input type="number" step="0.01" wire:model.defer="valor" placeholder="Ex: 500.00" class="input input-bordered w-full" />
                        @error('valor') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-control md:col-span-2">
                        <label class="label"><span class="label-text">Observações (Opcional)</span></label>
                        <textarea wire:model.defer="observacoes" class="textarea textarea-bordered h-24" placeholder="Ex: Hóspede pediu berço, check-in tardio..."></textarea>
                         @error('observacoes') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="divider mt-8"></div>
                <div class="card-actions justify-end">
                    <a href="{{ route('dashboard') }}" class="btn btn-ghost">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        {{ $reserva->exists ? 'Salvar Alterações' : 'Salvar Reserva' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

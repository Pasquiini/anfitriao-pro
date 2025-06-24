<div>
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="card w-full bg-base-100 shadow-xl border">
            <div class="card-body">
                @if ($erroGeral)
                    <div role="alert" class="alert alert-error mb-4"><span>{{ $erroGeral }}</span></div>
                @endif

                <h2 class="card-title text-2xl mb-4">
                    {{ $imovel->exists ? 'Editar Imóvel' : 'Cadastrar Novo Imóvel' }}
                </h2>

                <form wire:submit.prevent="salvar">
                    {{-- Usamos uma grade para um layout mais organizado --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        {{-- Campo Nome --}}
                        <div class="form-control w-full md:col-span-2">
                            <label class="label"><span class="label-text">Nome do Imóvel</span></label>
                            <input type="text" wire:model.defer="nome" placeholder="Ex: Casa com piscina e vista para o lago" class="input input-bordered w-full" />
                            @error('nome') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Campo Endereço --}}
                        <div class="form-control w-full md:col-span-2">
                            <label class="label"><span class="label-text">Endereço Completo</span></label>
                            <input type="text" wire:model.defer="endereco" placeholder="Ex: Rua das Flores, 123, Centro, Lagoa Santa - GO" class="input input-bordered w-full" />
                            @error('endereco') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Campos de Detalhes Estruturados --}}
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text">Nº de Quartos</span></label>
                            <input type="number" wire:model.defer="quartos" placeholder="Ex: 3" class="input input-bordered w-full" />
                             @error('quartos') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text">Nº de Banheiros</span></label>
                            <input type="number" wire:model.defer="banheiros" placeholder="Ex: 2" class="input input-bordered w-full" />
                             @error('banheiros') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text">Acomoda (Pessoas)</span></label>
                            <input type="number" wire:model.defer="acomoda" placeholder="Ex: 8" class="input input-bordered w-full" />
                             @error('acomoda') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Campo Descrição --}}
                        <div class="form-control w-full md:col-span-2">
                            <label class="label"><span class="label-text">Descrição Detalhada (Opcional)</span></label>
                            <textarea wire:model.defer="descricao" class="textarea textarea-bordered h-24" placeholder="Fale mais sobre o espaço, regras da casa, etc..."></textarea>
                            @error('descricao') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Seção de Comodidades --}}
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-base-content">Comodidades</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-4">
                            @foreach($listaComodidades as $key => $label)
                                <label class="label cursor-pointer justify-start gap-2">
                                    <input type="checkbox" wire:model.defer="comodidades" value="{{ $key }}" class="checkbox checkbox-primary" />
                                    <span class="label-text">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                         @error('comodidades') <span class="text-error text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Botões de Ação --}}
                    <div class="divider mt-8"></div>
                    <div class="card-actions justify-end">
                        <a href="{{ route('imoveis.index') }}" class="btn btn-ghost">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            {{ $imovel->exists ? 'Salvar Alterações' : 'Salvar Imóvel' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

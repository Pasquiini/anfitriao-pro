<div class="p-4 sm:p-6 lg:p-8">
    {{-- Alerta de sucesso (código existente) --}}
    @if (session()->has('sucesso'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" role="alert" class="alert alert-success mb-4">
            <span>{{ session('sucesso') }}</span>
        </div>
    @endif

    {{-- =================================================== --}}
    {{--    INÍCIO DA NOVA BARRA DE FERRAMENTAS           --}}
    {{-- =================================================== --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <!-- Campo de Busca -->
        <div class="form-control w-full md:w-1/3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por nome ou endereço..." class="input input-bordered w-full" />
        </div>

        <!-- Botão de Cadastrar -->
        <a href="{{ route('imoveis.create') }}" class="btn btn-primary w-full md:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Cadastrar Novo Imóvel
        </a>
    </div>
    {{-- =================================================== --}}
    {{--    FIM DA NOVA BARRA DE FERRAMENTAS                --}}
    {{-- =================================================== --}}

    {{-- Lista de Imóveis (código existente, agora dentro de um div) --}}
    <div class="space-y-4">
        @forelse ($imoveis as $imovel)
            <div class="card w-full bg-base-100 shadow-md border hover:shadow-lg transition-shadow">
                <div class="card-body flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div>
                        <h2 class="card-title">{{ $imovel->nome }}</h2>
                        <p class="text-sm text-base-content/60">{{ $imovel->endereco }}</p>
                    </div>
                    <div class="card-actions justify-end mt-4 sm:mt-0">
                        {{-- O link de detalhes que tínhamos antes, agora pode ser útil aqui --}}
                        <a href="{{ route('imoveis.detalhes', $imovel) }}" class="btn btn-ghost btn-sm">Ver Reservas</a>
                        <a href="{{ route('imoveis.edit', $imovel) }}" class="btn btn-ghost btn-sm">Editar</a>
                        <button wire:click="deletar({{ $imovel->id }})" wire:confirm="Tem certeza?" class="btn btn-error btn-outline btn-sm">Excluir</button>
                    </div>
                </div>
            </div>
        @empty
            {{-- NOVO ESTADO VAZIO, MAIS INTELIGENTE --}}
            <div class="text-center py-16">
                <h3 class="text-2xl font-semibold">Nenhum imóvel encontrado.</h3>
                <p class="text-base-content/60 mt-2 mb-6">Parece que você ainda não cadastrou nenhuma propriedade.</p>
                <a href="{{ route('imoveis.create') }}" class="btn btn-primary">
                    Cadastrar meu primeiro imóvel
                </a>
            </div>
        @endforelse
    </div>

    {{-- LINKS DA PAGINAÇÃO --}}
    <div class="mt-8">
        {{ $imoveis->links() }}
    </div>
</div>

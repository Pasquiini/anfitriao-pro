<?php

namespace App\Livewire\Imoveis;

use App\Models\Imovel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ListarImoveis extends Component
{
    use WithPagination; // 2. "Ativa" a paginação no componente

    // 3. Novas propriedades para controlar os filtros
    public $search = '';
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';
    public function deletar($imovelId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $imovel = $user->imoveis()->findOrFail($imovelId);
        $imovel->delete();
        session()->flash('sucesso', 'Imóvel excluído com sucesso!');
    }

    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir === "ASC") ? 'DESC' : "ASC";
            return;
        }
        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $imoveis = Imovel::where('user_id', $user->id)
            ->when($this->search, function ($query) {
                $query->where('nome', 'like', '%' . $this->search . '%')
                    ->orWhere('endereco', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(10); // 4. Em vez de ->get(), usamos ->paginate()

        return view('livewire.imoveis.listar-imoveis', [
            'imoveis' => $imoveis
        ]);
    }
}

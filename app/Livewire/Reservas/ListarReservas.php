<?php

namespace App\Livewire\Reservas;

use App\Models\Imovel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ListarReservas extends Component
{
    use WithPagination;
    public Imovel $imovel;

    public $search = '';
    public $filterStatus = '';
    public $sortBy = 'data_inicio';
    public $sortDir = 'DESC';

    public function mount(Imovel $imovel)
    {
        // Garante que o usuário só possa ver os detalhes dos seus próprios imóveis
        if ($imovel->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado');
        }
        $this->imovel = $imovel;
    }

    // Método para alterar a ordenação
    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir === "ASC") ? 'DESC' : "ASC";
            return;
        }
        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    // Método para limpar todos os filtros
    public function clearFilters()
    {
        $this->reset('search', 'filterStatus');
    }

    public function render()
    {
        $reservas = $this->imovel->reservas()
            ->when($this->search, function ($query) {
                // Filtra pelo nome do hóspede
                $query->where('nome_hospede', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus, function ($query) {
                // Filtra pelo status
                $query->where('status', $this->filterStatus);
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate(10); // 4. Pagina os resultados

        return view('livewire.reservas.listar-reservas', [
            'reservas' => $reservas,
        ]);
    }
}

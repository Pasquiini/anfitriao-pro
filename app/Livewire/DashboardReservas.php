<?php

namespace App\Livewire;

use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class DashboardReservas extends Component
{
    use WithPagination;

    // Propriedades para os filtros
    public $search = '';
    public $filterImovelId = '';
    public $filterStatus = '';
    public $filterDataInicio = '';
    public $filterDataFim = '';
    public $sortBy = 'data_inicio';
    public $sortDir = 'ASC';

    public $showNovaReservaModal = false;
    public $imovelSelecionadoId = null;
    public $showBloqueioModal = false;
    public $imovelBloqueioId = null;
    public $dataInicioBloqueio = '';
    public $dataFimBloqueio = '';
    public $motivoBloqueio = '';
    public $reservaParaCancelarId = null;
    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir === "ASC") ? 'DESC' : "ASC";
            return;
        }
        $this->sortBy = $sortByField;
        $this->sortDir = 'ASC';
    }

    public function abrirModalCancelamento($reservaId)
    {
        $this->reservaParaCancelarId = $reservaId;
    }

    public function fecharModalCancelamento()
    {
        $this->reservaParaCancelarId = null;
    }

    public function clearFilters()
    {
        $this->reset('search', 'filterImovelId', 'filterStatus', 'filterDataInicio', 'filterDataFim');
    }
    public function salvarBloqueio()
    {
        $dadosValidados = $this->validate([
            'imovelBloqueioId' => 'required|exists:imoveis,id',
            'dataInicioBloqueio' => 'required|date|after_or_equal:today',
            'dataFimBloqueio' => 'required|date|after:dataInicioBloqueio',
            'motivoBloqueio' => 'required|string|min:3',
        ]);

        // Reutilizamos a lógica anti-overbooking!
        $conflitos = Reserva::where('imovel_id', $dadosValidados['imovelBloqueioId'])
            ->where(function ($query) use ($dadosValidados) {
                $query->where(function ($q) use ($dadosValidados) {
                    $q->where('data_inicio', '<=', $dadosValidados['dataInicioBloqueio'])->where('data_fim', '>=', $dadosValidados['dataInicioBloqueio']);
                })->orWhere(function ($q) use ($dadosValidados) {
                    $q->where('data_inicio', '<=', $dadosValidados['dataFimBloqueio'])->where('data_fim', '>=', $dadosValidados['dataFimBloqueio']);
                })->orWhere(function ($q) use ($dadosValidados) {
                    $q->where('data_inicio', '>=', $dadosValidados['dataInicioBloqueio'])->where('data_fim', '<=', $dadosValidados['dataFimBloqueio']);
                });
            })->exists();

        if ($conflitos) {
            // Adicionamos um erro personalizado ao formulário do modal
            $this->addError('dataInicioBloqueio', 'Este período conflita com uma reserva existente.');
            return;
        }

        // Criamos a "reserva" com status "bloqueado"
        Reserva::create([
            'imovel_id' => $dadosValidados['imovelBloqueioId'],
            'data_inicio' => $dadosValidados['dataInicioBloqueio'],
            'data_fim' => $dadosValidados['dataFimBloqueio'],
            'nome_hospede' => $dadosValidados['motivoBloqueio'], // Usamos o campo de hóspede para o motivo
            'contato_hospede' => 'Proprietário',
            'status' => 'bloqueado',
            'valor' => 0,
        ]);

        session()->flash('sucesso', 'Período bloqueado com sucesso!');
        $this->showBloqueioModal = false;
        $this->reset('imovelBloqueioId', 'dataInicioBloqueio', 'dataFimBloqueio', 'motivoBloqueio');
    }

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $meusImoveis = $user->imoveis()->orderBy('nome')->get();
        $meusImoveisIds = $meusImoveis->pluck('id');

        // Lógica da Query principal com filtros
        $reservasQuery = Reserva::with('imovel')
            ->whereIn('imovel_id', $meusImoveisIds)
            ->when($this->search, fn($q) => $q->where('nome_hospede', 'like', '%' . $this->search . '%'))
            ->when($this->filterImovelId, fn($q) => $q->where('imovel_id', $this->filterImovelId))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterDataInicio, fn($q) => $q->where('data_inicio', '>=', $this->filterDataInicio))
            ->when($this->filterDataFim, fn($q) => $q->where('data_fim', '<=', $this->filterDataFim));

        // Cálculo dos KPIs (Estatísticas)
        $hoje = Carbon::today()->toDateString();
        $checkinsHoje = (clone $reservasQuery)->where('data_inicio', $hoje)->where('status', 'confirmada')->count();
        $checkoutsHoje = (clone $reservasQuery)->where('data_fim', $hoje)->where('status', 'confirmada')->count();
        $faturamentoMes = (clone $reservasQuery)->where('status', 'confirmada')->whereMonth('data_inicio', Carbon::now()->month)->sum('valor');

        // Paginação dos resultados para a tabela
        $reservas = (clone $reservasQuery)->orderBy($this->sortBy, $this->sortDir)->paginate(15);

        return view('livewire.dashboard-reservas', [
            'reservas' => $reservas,
            'meusImoveis' => $meusImoveis,
            'checkinsHoje' => $checkinsHoje,
            'checkoutsHoje' => $checkoutsHoje,
            'faturamentoMes' => $faturamentoMes,
        ]);
    }

    public function fecharModal()
    {
        $this->showNovaReservaModal = false;
        $this->imovelSelecionadoId = null;
    }

  public function cancelarReserva($reservaId)
    {
        $reserva = Reserva::findOrFail($reservaId);

        if ($reserva->imovel->user_id !== Auth::id()) {
            abort(403);
        }

        $reserva->update(['status' => 'cancelada']);

        session()->flash('sucesso', 'Reserva cancelada com sucesso!');
        $this->fecharModalCancelamento();
    }
}

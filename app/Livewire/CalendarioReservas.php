<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Reserva; // Não se esqueça de importar o Model Reserva
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class CalendarioReservas extends Component
{
    public $imovelFiltroId = '';
    public ?Reserva $reservaSelecionada = null;

    /**
     * Carrega os detalhes de uma reserva para serem exibidos no modal.
     * Este método será chamado pelo JavaScript do calendário.
     */
    public function verDetalhesReserva($reservaId)
    {
        $this->reservaSelecionada = Reserva::with('imovel')->find($reservaId);
    }

    /**
     * Fecha o modal de detalhes.
     */
    public function fecharModalDetalhes()
    {
        $this->reservaSelecionada = null;
    }

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $meusImoveis = $user->imoveis()->orderBy('nome')->get();
        $meusImoveisIds = $meusImoveis->pluck('id');

        // Lógica para os eventos do calendário, agora respeitando o filtro
        $eventos = Reserva::with('imovel')
            ->whereIn('imovel_id', $meusImoveisIds)
            ->when($this->imovelFiltroId, function ($query) {
                $query->where('imovel_id', $this->imovelFiltroId);
            })
            ->get()
            ->map(function (Reserva $reserva) {
                $dataFim = Carbon::parse($reserva->data_fim)->addDay()->toDateString();
                $color = '#6B7280';
                if ($reserva->status === 'confirmada') $color = '#10B981';
                if ($reserva->status === 'bloqueado') $color = '#F59E0B';
                return [
                    'id'    => $reserva->id, // Passamos o ID para o evento
                    'title' => $reserva->imovel->nome,
                    'start' => $reserva->data_inicio,
                    'end'   => $dataFim,
                    'color' => $color,
                    'borderColor' => $color,
                ];
            })->all();

        // Lógica para a sidebar, agora também respeitando o filtro
        $baseQuery = Reserva::with('imovel')
            ->whereIn('imovel_id', $meusImoveisIds)
            ->where('status', 'confirmada')
            ->when($this->imovelFiltroId, function ($query) {
                $query->where('imovel_id', $this->imovelFiltroId);
            });

        $proximosCheckins = (clone $baseQuery)->whereBetween('data_inicio', [now(), now()->addDays(7)])->orderBy('data_inicio', 'asc')->get();
        $proximosCheckouts = (clone $baseQuery)->whereBetween('data_fim', [now(), now()->addDays(7)])->orderBy('data_fim', 'asc')->get();

        return view('livewire.calendario-reservas', [
            'eventos' => $eventos,
            'proximosCheckins' => $proximosCheckins,
            'proximosCheckouts' => $proximosCheckouts,
            'meusImoveis' => $meusImoveis,
        ]);
    }
}

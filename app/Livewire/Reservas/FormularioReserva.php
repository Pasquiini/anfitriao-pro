<?php

namespace App\Livewire\Reservas;

use App\Models\Imovel;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class FormularioReserva extends Component
{
    public ?Imovel $imovel = null;
    public Reserva $reserva;

    public $data_inicio = '';
    public $data_fim = '';
    public $nome_hospede = '';
    public $contato_hospede = '';
    public $valor = null;
    public $numero_hospedes = null;
    public $observacoes = '';

    /**
     * Este é o novo mount "inteligente". Ele aceita tanto um Imovel (para criar)
     * quanto uma Reserva (para editar). Ambos são anuláveis.
     */
    public function mount($imovelId = null, $reservaId = null)
    {
        if ($reservaId) {
            $reserva = Reserva::findOrFail($reservaId);
            if ($reserva->imovel->user_id !== Auth::id()) {
                abort(403);
            }
            $this->reserva = $reserva;
            $this->imovel = $this->reserva->imovel;
            $this->fill(
                $this->reserva->only([
                    'data_inicio',
                    'data_fim',
                    'nome_hospede',
                    'contato_hospede',
                    'valor',
                    'numero_hospedes',
                    'observacoes',
                ])
            );
        } elseif ($imovelId) {
            $this->imovel = Imovel::findOrFail($imovelId);
            if ($this->imovel->user_id !== Auth::id()) {
                abort(403);
            }
            $this->reserva = new Reserva();
        } else {
            session()->flash('erro', 'Contexto inválido para o formulário de reserva.');
            return redirect()->route('dashboard');
        }
    }

    protected function rules()
    {
        return [
            'data_inicio' => 'required|date|after_or_equal:today',
            'data_fim' => 'required|date|after:data_inicio',
            'nome_hospede' => 'required|string|min:3',
            'contato_hospede' => 'required|string|min:5',
            'valor' => 'nullable|numeric|min:0',
            'numero_hospedes' => 'nullable|integer|min:1',
            'observacoes' => 'nullable|string',
        ];
    }


    public function salvarReserva()
    {
        $dadosValidados = $this->validate();

        // Lógica anti-overbooking melhorada
        $dataInicio = $dadosValidados['data_inicio'];
        $dataFim = $dadosValidados['data_fim'];
        $queryConflitos = $this->imovel->reservas();

        // Se estamos editando, excluímos a própria reserva da verificação
        if ($this->reserva->exists) {
            $queryConflitos->where('id', '!=', $this->reserva->id);
        }

        $conflitos = $this->imovel->reservas()->where(function ($query) use ($dataInicio, $dataFim) {
            $query->where(function ($q) use ($dataInicio, $dataFim) {
                $q->where('data_inicio', '<=', $dataInicio)->where('data_fim', '>=', $dataInicio);
            })->orWhere(function ($q) use ($dataInicio, $dataFim) {
                $q->where('data_inicio', '<=', $dataFim)->where('data_fim', '>=', $dataFim);
            })->orWhere(function ($q) use ($dataInicio, $dataFim) {
                $q->where('data_inicio', '>=', $dataInicio)->where('data_fim', '<=', $dataFim);
            });
        })->exists();

        if ($conflitos) {
            throw ValidationException::withMessages([
                'data_inicio' => 'Este período não está disponível.',
            ]);
        }

        // Lógica para decidir se cria ou atualiza
        if ($this->reserva->exists) {
            $this->reserva->update($dadosValidados);
            session()->flash('sucesso', 'Reserva atualizada com sucesso!');
        } else {
            $this->imovel->reservas()->create($dadosValidados);
            session()->flash('sucesso', 'Reserva cadastrada com sucesso!');
        }

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.reservas.formulario-reserva');
    }
}

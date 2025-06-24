<?php

namespace App\Livewire\Imoveis;

use App\Models\Imovel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class FormularioImovel extends Component
{
    // Propriedade para guardar o imóvel (se estiver editando)
    public Imovel $imovel;

    public $nome = '';
    public $endereco = '';
    public $descricao = '';

    // Novas propriedades
    public $quartos = null;
    public $banheiros = null;
    public $acomoda = null;
    public $comodidades = []; // Será um array para os checkboxes

    public ?string $erroGeral = null;

    // Lista de comodidades disponíveis para seleção
    public $listaComodidades = [
        'wifi' => 'Wi-Fi',
        'piscina' => 'Piscina',
        'churrasqueira' => 'Churrasqueira',
        'ar_condicionado' => 'Ar Condicionado',
        'estacionamento' => 'Estacionamento',
        'tv_cabo' => 'TV a Cabo',
        'cozinha_completa' => 'Cozinha Completa',
        'pet_friendly' => 'Aceita Pets',
    ];

    public function mount(Imovel $imovel)
    {
        $this->imovel = $imovel;
        if ($this->imovel->exists) {
            $this->nome = $this->imovel->nome;
            $this->endereco = $this->imovel->endereco;
            $this->descricao = $this->imovel->descricao;
            $this->quartos = $this->imovel->quartos;
            $this->banheiros = $this->imovel->banheiros;
            $this->acomoda = $this->imovel->acomoda;
            // Garante que comodidades seja um array, mesmo se for nulo no banco
            $this->comodidades = $this->imovel->comodidades ?? [];
        }
    }

    /**
     * Método para salvar (seja criando ou atualizando).
     */
    public function salvar()
    {
        $this->reset('erroGeral');

        $dadosValidados = $this->validate([
            'nome' => 'required|string|min:5',
            'endereco' => 'required|string|min:10',
            'descricao' => 'nullable|string',
            'quartos' => 'nullable|integer|min:0',
            'banheiros' => 'nullable|integer|min:0',
            'acomoda' => 'nullable|integer|min:0',
            'comodidades' => 'nullable|array',
        ]);

        try {
            if ($this->imovel->exists) {
                $this->imovel->update($dadosValidados);
                session()->flash('sucesso', 'Imóvel atualizado com sucesso!');
            } else {
                /** @var \App\Models\User $user */
                $user = Auth::user();
                $user->imoveis()->create($dadosValidados);
                session()->flash('sucesso', 'Imóvel cadastrado com sucesso!');
            }
            return redirect()->route('imoveis.index');
        } catch (\Exception $e) {
            $this->erroGeral = 'Ocorreu uma falha ao salvar o imóvel. Por favor, tente novamente.';
        }
    }

    /**
     * Renderiza a view do formulário.
     */
    public function render()
    {
        return view('livewire.imoveis.formulario-imovel');
    }
}

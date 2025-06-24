<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\CalendarioReservas;
use App\Livewire\DashboardReservas;
use App\Livewire\Imoveis\FormularioImovel;
use App\Livewire\Imoveis\ListarImoveis;
use App\Livewire\Reservas\FormularioReserva;
use App\Livewire\Reservas\ListarReservas;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardReservas::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // IMOVEIS
    Route::get('/imoveis', ListarImoveis::class)->name('imoveis.index');
    Route::get('/imoveis/create', FormularioImovel::class)->name('imoveis.create');
    Route::get('/imoveis/{imovel}/editar', FormularioImovel::class)->name('imoveis.edit');

    // RESERVAS
    Route::get('/imoveis/{imovel}', ListarReservas::class)->name('imoveis.detalhes');
    Route::get('/imoveis/{imovelId}/reservas/criar', FormularioReserva::class)->name('reservas.create');

     Route::get('/reservas/{reservaId}/editar', FormularioReserva::class)->name('reservas.edit');

    Route::get('/calendario', CalendarioReservas::class)->name('calendario');
});

require __DIR__ . '/auth.php';

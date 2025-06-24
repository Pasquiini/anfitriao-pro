<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imovel extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'imoveis';

    protected $fillable = [
        'user_id',
        'nome',
        'endereco',
        'descricao',
        'quartos',
        'banheiros',
        'acomoda',
        'comodidades',
    ];

    protected $casts = [
        'comodidades' => 'array',
    ];

    /**
     * Get the user that owns the Imovel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }
}

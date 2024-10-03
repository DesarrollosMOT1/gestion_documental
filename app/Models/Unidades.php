<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Unidade
 *
 * @property $id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 * @property Registro[] $registros
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Unidades extends Model
{
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registros()
    {
        return $this->hasMany(\App\Models\Registro::class, 'id', 'unidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equivalencias()
    {
        return $this->hasMany(\App\Models\Equivalencia::class, 'unidad_principal', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *                                                         retorna la unidad equivalente
     */
    //retorna la unidad equivalente
    public function equivalenciasComoEquivalente()
    {
        return $this->hasMany(\App\Models\Equivalencia::class, 'unidad_equivalente', 'id');
    }
}

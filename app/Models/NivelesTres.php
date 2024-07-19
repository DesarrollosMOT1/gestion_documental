<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NivelesTre
 *
 * @property $id
 * @property $nombre
 * @property $id_niveles_dos
 * @property $id_referencias_gastos
 * @property $created_at
 * @property $updated_at
 *
 * @property NivelesDo $nivelesDo
 * @property ReferenciasGasto $referenciasGasto
 * @property SolicitudesElemento[] $solicitudesElementos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class NivelesTres extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'id_niveles_dos', 'id_referencias_gastos'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nivelesDos()
    {
        return $this->belongsTo(\App\Models\NivelesDos::class, 'id_niveles_dos', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referenciasGasto()
    {
        return $this->belongsTo(\App\Models\ReferenciaGasto::class, 'id_referencias_gastos', 'codigo');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudesElementos()
    {
        return $this->hasMany(\App\Models\SolicitudesElemento::class, 'id', 'id_niveles_tres');
    }
    
}

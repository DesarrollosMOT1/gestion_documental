<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

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
 * @property NivelesDos $nivelesDo
 * @property ReferenciasGasto $referenciasGasto
 * @property SolicitudesElemento[] $solicitudesElementos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class NivelesTres extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $perPage = 20;

    protected $table = 'niveles_tres';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'id_niveles_dos', 'id_referencias_gastos', 'inventario', 'unidad_id'];


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
        return $this->belongsTo(\App\Models\referenciasGasto::class, 'id_referencias_gastos', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudesElementos()
    {
        return $this->hasMany(\App\Models\SolicitudesElemento::class, 'id', 'id_niveles_tres');
    }

    public function unidades()
    {
        return $this->belongsToMany(\App\Models\Unidades::class, 'nivel_tres_unidades', 'nivel_tres_id', 'unidad_id');
    }
}

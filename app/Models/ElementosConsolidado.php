<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class ElementosConsolidado
 *
 * @property $id
 * @property $id_consolidacion
 * @property $id_solicitud_compra
 * @property $id_solicitud_elemento
 * @property $created_at
 * @property $updated_at
 *
 * @property Consolidacione $consolidacione
 * @property SolicitudesCompra $solicitudesCompra
 * @property SolicitudesElemento $solicitudesElemento
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ElementosConsolidado extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id_consolidacion', 'id_solicitud_compra', 'id_solicitud_elemento'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consolidacione()
    {
        return $this->belongsTo(\App\Models\Consolidacione::class, 'id_consolidacion', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudesCompra()
    {
        return $this->belongsTo(\App\Models\SolicitudesCompra::class, 'id_solicitud_compra', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function solicitudesElemento()
    {
        return $this->belongsTo(\App\Models\SolicitudesElemento::class, 'id_solicitud_elemento', 'id');
    }
    
}

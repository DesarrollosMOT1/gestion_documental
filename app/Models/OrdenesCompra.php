<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrdenesCompra
 *
 * @property $id
 * @property $fecha_emision
 * @property $subtotal
 * @property $total
 * @property $cantidad_total
 * @property $nota
 * @property $created_at
 * @property $updated_at
 *
 * @property OrdenesCompraCotizacione[] $ordenesCompraCotizaciones
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class OrdenesCompra extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['fecha_emision', 'subtotal', 'total', 'cantidad_total', 'nota'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordenesCompraCotizaciones()
    {
        return $this->hasMany(\App\Models\OrdenesCompraCotizacione::class, 'id', 'id_ordenes_compras');
    }
    
}

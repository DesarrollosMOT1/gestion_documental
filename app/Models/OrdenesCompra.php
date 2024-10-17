<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrdenesCompra
 *
 * @property $id
 * @property $fecha_emision
 * @property $created_at
 * @property $updated_at
 * @property $id_terceros
 *
 * @property Tercero $tercero
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
    protected $fillable = ['fecha_emision', 'id_terceros', 'id_users'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tercero()
    {
        return $this->belongsTo(\App\Models\Tercero::class, 'id_terceros', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordenesCompraCotizaciones()
    {
        return $this->hasMany(\App\Models\OrdenesCompraCotizacione::class, 'id_ordenes_compras', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_users', 'id');
    }
    
}

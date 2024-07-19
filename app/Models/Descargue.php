<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Descargue
 *
 * @property $id
 * @property $cliente_id
 * @property $fecha_descargue
 * @property $created_at
 * @property $updated_at
 *
 * @property Cliente $cliente
 * @property DescarguesProducto[] $descarguesProductos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Descargue extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['cliente_id', 'fecha_descargue'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'cliente_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descarguesProductos()
    {
        return $this->hasMany(\App\Models\DescarguesProducto::class, 'id', 'descargue');
    }
    
}

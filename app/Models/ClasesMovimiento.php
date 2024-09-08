<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClasesMovimiento
 *
 * @property $id
 * @property $nombre
 * @property $descripcion
 * @property $tipo
 * @property $created_at
 * @property $updated_at
 *
 * @property TiposMovimiento $tiposMovimiento
 * @property Movimiento[] $movimientos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ClasesMovimiento extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'descripcion', 'tipo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposMovimiento()
    {
        return $this->belongsTo(\App\Models\TiposMovimiento::class, 'tipo', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movimientos()
    {
        return $this->hasMany(\App\Models\Movimiento::class, 'id', 'clase');
    }
    
}

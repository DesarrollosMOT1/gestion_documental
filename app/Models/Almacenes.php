<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Almacenes
 *
 * @property $id
 * @property $bodega
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 * @property Bodega $bodega
 * @property Movimiento[] $movimientos
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Almacenes extends Model
{
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['bodega', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bodega()
    {
        return $this->belongsTo(\App\Models\Bodega::class, 'id', 'bodega');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movimientos()
    {
        return $this->hasMany(\App\Models\Movimiento::class, 'id', 'almacen');
    }
}

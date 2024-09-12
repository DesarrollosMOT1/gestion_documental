<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Movimiento
 *
 * @property $id
 * @property $tipo
 * @property $clase
 * @property $almacen
 * @property $fecha
 * @property $descripcion
 * @property $created_at
 * @property $updated_at
 * @property Almacenes $Almacenes
 * @property TiposMovimiento $ tiposMovimiento
 * @property ClasesMovimiento $clasesMovimiento
 * @property Registro[] $registros
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Movimiento extends Model
{
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['tipo', 'clase', 'almacen', 'fecha', 'descripcion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Almacenes()
    {
        return $this->belongsTo(\App\Models\Almacenes::class, 'almacen', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiposMovimiento()
    {
        return $this->belongsTo(\App\Models\TiposMovimiento::class, 'tipo', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clasesMovimiento()
    {
        return $this->belongsTo(\App\Models\ClasesMovimiento::class, 'clase', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registros()
    {
        return $this->hasMany(\App\Models\Registro::class, 'movimiento', 'id');
    }
}

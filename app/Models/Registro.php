<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Registro
 *
 * @property $id
 * @property $producto
 * @property $tercero
 * @property $unidad
 * @property $movimiento
 * @property $cantidad
 * @property $motivo
 * @property $detalle_registro
 * @property $created_at
 * @property $updated_at
 * @property Motivo $motivo
 * @property Movimiento $movimiento
 * @property Producto $producto
 * @property Tercero $tercerostest
 * @property Unidades $unidades
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Registro extends Model
{
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['producto', 'tercero', 'unidad', 'movimiento', 'cantidad', 'motivo', 'detalle_registro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motivo()
    {
        return $this->belongsTo(\App\Models\Motivo::class, 'motivo', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movimiento()
    {
        return $this->belongsTo(\App\Models\Movimiento::class, 'movimiento', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo(\App\Models\Producto::class, 'producto', 'codigo_producto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tercerostest()
    {
        return $this->belongsTo(\App\Models\Tercerostest::class, 'tercero', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidades()
    {
        return $this->belongsTo(\App\Models\Unidades::class, 'unidad', 'id');
    }
}

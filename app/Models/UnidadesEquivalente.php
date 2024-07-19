<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UnidadesEquivalente
 *
 * @property $id
 * @property $unidad_principal
 * @property $unidad_equivalente
 * @property $cantidad
 * @property $created_at
 * @property $updated_at
 *
 * @property Producto $producto
 * @property Producto $producto
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class UnidadesEquivalente extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['unidad_principal', 'unidad_equivalente', 'cantidad'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo(\App\Models\Producto::class, 'unidad_equivalente', 'codigo_producto');
    }

}

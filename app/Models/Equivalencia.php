<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Equivalencia
 *
 * @property $id
 * @property $unidad_principal
 * @property $unidad_equivalente
 * @property $cantidad
 * @property $created_at
 * @property $updated_at
 * @property Unidades $unidad
 * @property Unidades $unidad
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Equivalencia extends Model
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
    public function unidad_equivalente()
    {
        return $this->belongsTo(\App\Models\Unidades::class, 'unidad_equivalente', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidad_principal()
    {
        return $this->belongsTo(\App\Models\Unidades::class, 'unidad_principal', 'id');
    }
}

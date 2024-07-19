<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 *
 * @property $id
 * @property $nombre
 * @property $codigo_producto
 * @property $unidad_medida
 * @property $medida
 * @property $created_at
 * @property $updated_at
 *
 * @property UnidadesEquivalente[] $unidadesEquivalentes
 * @property UnidadesEquivalente[] $unidadesEquivalentes
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Producto extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'codigo_producto', 'unidad_medida', 'medida'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unidadesEquivalentes()
    {
        return $this->hasMany(\App\Models\UnidadesEquivalente::class, 'codigo_producto', 'unidad_equivalente');
    }

}

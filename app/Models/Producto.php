<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 *
 * @property $codigo_producto
 * @property $nombre
 * @property $unidad_medida_peso
 * @property $peso_bruto
 * @property $medida_volumen
 * @property $ean
 * @property $created_at
 * @property $updated_at
 * @property Registro[] $registros
 *
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
    protected $fillable = ['codigo_producto', 'nombre', 'unidad_medida_peso', 'peso_bruto', 'medida_volumen', 'ean'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'codigo_producto';

    /**
     * Indicates if the primary key is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registros()
    {
        return $this->hasMany(\App\Models\Registro::class, 'codigo_producto', 'producto');
    }
}

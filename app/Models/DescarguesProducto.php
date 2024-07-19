<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DescarguesProducto
 *
 * @property $id
 * @property $descargue
 * @property $producto
 * @property $cantidad
 * @property $created_at
 * @property $updated_at
 *
 * @property Descargue $descargue
 * @property Producto $producto
 * @property EstibaProducto[] $estibaProductos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DescarguesProducto extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['descargue', 'producto', 'cantidad'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function descargue()
    {
        return $this->belongsTo(\App\Models\Descargue::class, 'descargue', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function producto()
    {
        return $this->belongsTo(\App\Models\Producto::class, 'producto', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function estibaProductos()
    {
        return $this->hasMany(\App\Models\EstibaProducto::class, 'id', 'descargue');
    }
    
}

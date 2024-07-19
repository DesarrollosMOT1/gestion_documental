<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Estiba
 *
 * @property $id
 * @property $unidad_medida
 * @property $medida
 * @property $created_at
 * @property $updated_at
 *
 * @property EstibaProducto[] $estibaProductos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Estiba extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['unidad_medida', 'medida'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function estibaProductos()
    {
        return $this->hasMany(\App\Models\EstibaProducto::class, 'id', 'estiba');
    }
    
}

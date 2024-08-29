<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReferenciasGasto
 *
 * @property $id
 * @property $codigo_mekano
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property NivelesTres[] $nivelesTres
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ReferenciasGasto extends Model
{
    
    protected $perPage = 2000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['codigo_mekano', 'nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nivelesTres()
    {
        return $this->hasMany(\App\Models\NivelesTres::class, 'id', 'id_referencias_gastos');
    }
    
}

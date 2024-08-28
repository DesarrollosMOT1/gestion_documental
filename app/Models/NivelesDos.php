<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NivelesDo
 *
 * @property $id
 * @property $nombre
 * @property $id_niveles_uno
 * @property $created_at
 * @property $updated_at
 *
 * @property NivelesUno $nivelesUno
 * @property NivelesTres[] $nivelesTres
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class NivelesDos extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'id_niveles_uno', 'inventario'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nivelesUno()
    {
        return $this->belongsTo(\App\Models\NivelesUno::class, 'id_niveles_uno', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nivelesTres()
    {
        return $this->hasMany(\App\Models\NivelesTres::class, 'id_niveles_dos', 'id');
    }
    
}

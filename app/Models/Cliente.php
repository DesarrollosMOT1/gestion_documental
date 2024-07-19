<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 *
 * @property $id
 * @property $nombre
 * @property $unidad_medida
 * @property $correo
 * @property $created_at
 * @property $updated_at
 *
 * @property Descargue[] $descargues
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Cliente extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'unidad_medida', 'correo'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descargues()
    {
        return $this->hasMany(\App\Models\Descargue::class, 'id', 'cliente_id');
    }
    
}

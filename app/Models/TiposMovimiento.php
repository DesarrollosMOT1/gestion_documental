<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TiposMovimiento
 *
 * @property $id
 * @property $nombre
 * @property $descripcion
 * @property $created_at
 * @property $updated_at
 *
 * @property ClasesMovimiento[] $clasesMovimientos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TiposMovimiento extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'descripcion'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clasesMovimientos()
    {
        return $this->hasMany(\App\Models\ClasesMovimiento::class, 'id', 'tipo');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movimientos()
    {
        return $this->hasMany(\App\Models\Movimiento::class, 'id', 'tipo');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Motivo
 *
 * @property $id
 * @property $nombre
 * @property $descripcion
 * @property $created_at
 * @property $updated_at
 *
 * @property Registro[] $registros
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Motivo extends Model
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
    public function registros()
    {
        return $this->hasMany(\App\Models\Registro::class, 'id', 'motivo');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Bodega
 *
 * @property $id
 * @property $nombre
 * @property $direccion
 * @property $created_at
 * @property $updated_at
 *
 * @property Almacenes[] $Almacenes
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Bodega extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'direccion'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Almacenes()
    {
        return $this->hasMany(\App\Models\Almacenes::class, 'id', 'bodega');
    }

}

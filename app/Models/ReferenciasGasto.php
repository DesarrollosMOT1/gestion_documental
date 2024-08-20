<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReferenciasGasto
 *
 * @property $codigo
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property NivelesTre[] $nivelesTres
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ReferenciasGasto extends Model
{
    
    protected $perPage = 2000;

    protected $table = 'referencias_gastos'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'codigo';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['codigo', 'nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nivelesTres()
    {
        return $this->hasMany(\App\Models\NivelesTres::class, 'codigo', 'id_referencias_gastos');
    }
    
}

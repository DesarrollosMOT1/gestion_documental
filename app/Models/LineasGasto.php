<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LineasGasto
 *
 * @property $codigo
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property ReferenciaGasto[] $referenciaGastos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LineasGasto extends Model
{
    
    protected $perPage = 2000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'lineas_gasto';
    protected $primaryKey = 'codigo';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['codigo', 'nombre'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referenciaGastos()
    {
        return $this->hasMany(\App\Models\ReferenciaGasto::class, 'codigo', 'linea');
    }
    
}

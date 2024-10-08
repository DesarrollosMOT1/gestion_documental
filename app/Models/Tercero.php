<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tercero
 *
 * @property $nit
 * @property $tipo_factura
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property Cotizacione[] $cotizaciones
 * @property OrdenesCompra[] $ordenesCompras
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Tercero extends Model
{
    
    protected $perPage = 2000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'nit';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nit', 'tipo_factura', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cotizaciones()
    {
        return $this->hasMany(\App\Models\Cotizacione::class, 'nit', 'id_terceros');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordenesCompras() 
    {
        return $this->hasMany(\App\Models\OrdenesCompra::class, 'id_terceros', 'nit');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Tercero
 *
 * @property $id
 * @property $nit
 * @property $tipo_factura
 * @property $nombre
 * @property $email
 * @property $created_at
 * @property $updated_at
 * @property Cotizacione[] $cotizaciones
 * @property OrdenesCompra[] $ordenesCompras
 * @property SolicitudOfertaTercero[] $solicitudOfertaTerceros
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Tercero extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $perPage = 2000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nit', 'tipo_factura', 'nombre', 'email'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cotizaciones()
    {
        return $this->hasMany(\App\Models\Cotizacione::class, 'id', 'id_terceros');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordenesCompras()
    {
        return $this->hasMany(\App\Models\OrdenesCompra::class, 'id', 'id_terceros');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudOfertaTerceros()
    {
        return $this->hasMany(\App\Models\SolicitudOfertaTercero::class, 'id', 'tercero_id');
    }

    public function registros()
    {
        return $this->hasMany(\App\Models\Registro::class, 'nit', 'tercero');
    }
}

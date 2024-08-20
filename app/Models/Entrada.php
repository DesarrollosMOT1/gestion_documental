<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Entrada
 *
 * @property $id
 * @property $fecha_recepcion_factura
 * @property $adjunto
 * @property $numero
 * @property $id_users
 * @property $fecha
 * @property $estado
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property OrdenesCompraCotizacione[] $ordenesCompraCotizaciones
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Entrada extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['fecha_recepcion_factura', 'adjunto', 'numero', 'id_users', 'fecha', 'estado'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_users', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordenesCompraCotizaciones()
    {
        return $this->hasMany(\App\Models\OrdenesCompraCotizacione::class, 'id', 'id_entradas');
    }
    
}

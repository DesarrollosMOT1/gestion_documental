<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AgrupacionesConsolidacione
 *
 * @property $id
 * @property $user_id
 * @property $fecha_cotizacion
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property Consolidacione[] $consolidaciones
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class AgrupacionesConsolidacione extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'fecha_cotizacion'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consolidaciones()
    {
        return $this->hasMany(\App\Models\Consolidacione::class, 'agrupacion_id', 'id');
    }
    
}
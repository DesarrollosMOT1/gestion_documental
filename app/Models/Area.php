<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Area
 *
 * @property $id
 * @property $nombre
 * @property $created_at
 * @property $updated_at
 *
 * @property User[] $users
 * @property ClasificacionesCentro[] $clasificacionesCentros
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Area extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $perPage = 2000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'id', 'id_area');
    }

    /**
     * Relación de muchos a muchos con ClasificacionesCentro a través de ClasificacionesCentrosArea.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clasificacionesCentros()
    {
        return $this->belongsToMany(\App\Models\ClasificacionesCentro::class, 'clasificaciones_centros_areas', 'id_areas', 'id_clasificaciones_centros');
    }
}

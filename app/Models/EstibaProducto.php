<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EstibaProducto
 *
 * @property $id
 * @property $estiba
 * @property $descargue
 * @property $cantidad_producto
 * @property $created_at
 * @property $updated_at
 *
 * @property DescarguesProducto $descarguesProducto
 * @property Estiba $estiba
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class EstibaProducto extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['estiba', 'descargue', 'cantidad_producto'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function descarguesProducto()
    {
        return $this->belongsTo(\App\Models\DescarguesProducto::class, 'descargue', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estiba()
    {
        return $this->belongsTo(\App\Models\Estiba::class, 'estiba', 'id');
    }
    
}

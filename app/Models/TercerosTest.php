<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TercerosTest
 *
 * @property $id
 * @property $nombre
 * @property $correo
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TercerosTest extends Model
{

    protected $perPage = 20;
    protected $table = 'tercerostest';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'correo'];


}

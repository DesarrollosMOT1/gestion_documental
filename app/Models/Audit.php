<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Audit
 *
 * @property $id
 * @property $user_type
 * @property $user_id
 * @property $event
 * @property $auditable_type
 * @property $auditable_id
 * @property $old_values
 * @property $new_values
 * @property $url
 * @property $ip_address
 * @property $user_agent
 * @property $tags
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Audit extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_type', 'user_id', 'event', 'auditable_type', 'auditable_id', 'old_values', 'new_values', 'url', 'ip_address', 'user_agent', 'tags'];

    public function user()
    {
        return $this->morphTo();
    }

}

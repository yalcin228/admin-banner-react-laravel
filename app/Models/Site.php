<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static paginate()
 * @method static create(array $array)
 * @method static select(string $string)
 * @method static find(mixed $id)
 * @method static orderByDesc(string $string)
 * @property mixed $status
 * @property mixed $name
 */
class Site extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function places(): HasMany
    {
        return $this->hasMany(SiteCategory::class, 'site_id', 'id');
    }

    public function place(): HasOne
    {
        return $this->hasOne(SiteCategory::class, 'site_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static paginate(int $int)
 * @method static create(array $array)
 * @method static whereIn(string $string, \Illuminate\Support\Collection $ids)
 */
class BannerAds extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function sites(): BelongsTo
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function siteCategory(): BelongsTo
    {
        return $this->belongsTo(SiteCategory::class, 'category_id', 'id');
    }

    public function scopeBanners($query,$id)
    {
        return $query->where('status', 1)->where('site_id', $id);
    }
}

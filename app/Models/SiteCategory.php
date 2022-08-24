<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static orderByDesc(string $string)
 * @method static find(mixed $category_id)
 * @method static where(string $string, $id)
 */
class SiteCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'site_id',
        'image',
        'place',
        'type',
        'status',
        'category_id'
    ];

    public function sites():BelongsTo
    {
        return $this->belongsTo(Site::class,'site_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Resizable;
use TCG\Voyager\Traits\Translatable;


/**
 * App\Models\Portfolio
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $excerpt
 * @property string|null $excerpt_body
 * @property string|null $description
 * @property string|null $url
 * @property string|null $cover_image
 * @property string|null $media
 * @property string|null $images
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $order
 * @property-read null $translated
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereExcerptBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Portfolio withTranslations($locales = null, $fallback = true)
 * @mixin \Eloquent
 */
class Portfolio extends Model
{
    use Translatable, Resizable;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;


/**
 * App\Models\Post
 *
 * @property int $id
 * @property int $author_id
 * @property int $category_id
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string $body
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $status
 * @property int|null $featured
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read null $translated
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTranslation($field, $operator, $value = null, $locales = null, $default = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post withTranslations($locales = null, $fallback = true)
 * @mixin \Eloquent
 */
class Post extends Model implements Feedable
{
    use Translatable;

    protected $translatable = ['title', 'slug', 'body'];

    /**
     * Statuses.
     */
    const STATUS_PUBLISH = 'publish';
    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';

    /**
     * List of statuses.
     *
     * @var array
     */
    public static $statuses = [
        self::STATUS_PUBLISH,
        self::STATUS_DRAFT,
        self::STATUS_PENDING,
    ];

    protected $guarded = [];


    public function toFeedItem()
    {
        return FeedItem::create()
                ->id($this->id)
                ->title($this->title)
                ->summary($this->excerpt)
                ->updated($this->updated_at)
                ->link("/{$this->slug}")
                ->author('Jess G.');
    }


    public static function getFeedItems()
    {
        return Post::all();
    }


    public function getAuthorIdAttribute($value)
    {
        if (!$value) {
            $value = \Auth::user()->id;
        }

        return $value;
    }


    public function setAuthorIdAttribute($value)
    {
        if (!$value) {
            $value = \Auth::user()->id;
        }

        $this->attributes['author_id'] = $value;
    }


    public function getRouteKeyName()
    {
        if (in_array(\Route::getCurrentRoute()->action['as'], ['post.single'])) {
            return 'slug';
        }

        return 'id';
    }

}

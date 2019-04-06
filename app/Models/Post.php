<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;


class Post extends Model
{
    use Translatable;

    protected $translatable = ['title', 'slug', 'body'];

    /**
     * Statuses.
     */
    const STATUS_PUBLISH = 'PUBLISH';
    const STATUS_DRAFT = 'DRAFT';
    const STATUS_PENDING = 'PENDING';

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

}

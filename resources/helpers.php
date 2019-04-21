<?php
/**
 * Laravel helper functions
 */

use App\Models\Post;
use App\Models\Category;

use Carbon\Carbon;
use Embed\Embed;
use Embed\Exceptions\InvalidUrlException;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Facades\DB;

function body_class($class = '')
{
    $classes = [];
    $segments = \request()->segments();
    if (empty($segments)) {
        $classes[] = 'home';
    } else {
        $classes[] = $segments[0];
        switch ($segments[0]) {
            case 'archives':
                break;

            case 'category':
                if (isset($segments[2])) {
                    unset($classes[0]);
                    $classes[] = "single_post single_{$segments[2]}";
                } else {
                    $classes[] = "category_{$segments[1]}";
                }
                break;

            case 'pages':
                $classes[] = "page_{$segments[1]}";
                break;
        }
    }

    $classes[] = $class;
    if (empty($classes)) {
        return '';
    }

    $class_attr = 'class="' . trim(implode(' ', $classes)) . '"';

    return $class_attr;
}

/**
 * Return html string for post image
 * @param App\Models\Post $post
 * @param string $size
 * @return string
 */
function post_thumbnail($post, $size = '')
{
    if (!$post) {
        return '';
    }

    $html = '<img src="%s" alt="" />';

    $image = $post->image;
    if (!_file_exists($image)) {
        if (!_file_exists($post->category->image)) {
            return vsprintf($html, ['/assets/images/post-dummy-image.jpg']);
        }

        $image = $post->category->image;
    }

    if ($size) {
        $filePath = _file_exists($image, $size);
        if ($filePath) {
            $fileUrl = url('storage' . DIRECTORY_SEPARATOR . $filePath);
            return vsprintf($html, [$fileUrl]);
        }
    }

    return vsprintf($html, [url('storage' . DIRECTORY_SEPARATOR . $image)]);
}


/**
 * Check if a file exists. Return the filename if it does, otherwise false
 * @param string $image
 * @param string $size
 *
 * @return bool|string
 */
function _file_exists($image, $size = '')
{
    if (!$image) {
        return false;
    }

    $path = storage_path('app/public');
    $pathInfo = pathinfo($image);
    if ($size) {
        $size = "-{$size}";
    }

    $fileName =  $pathInfo['dirname']
        . DIRECTORY_SEPARATOR
        . "{$pathInfo['filename']}{$size}.{$pathInfo['extension']}";

    $filePath = $path . DIRECTORY_SEPARATOR . $fileName;
    if (!file_exists($filePath)) {
        return false;
    }

    return $fileName;
}


/**
 * Get archive data
 * @param boolean $list
 * @param int $limit Number of archive links to return
 *
 * @return string
 */
function get_archives($list = true, $limit = 10)
{

    $rawSql = DB::raw('YEAR(created_at) AS year, MONTH(created_at) AS month, MONTHNAME(created_at) AS month_name');
    $archives = Post::query()
        ->select($rawSql)
        ->groupBy('year')
        ->groupBy('month')
        ->groupBy('month_name')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit($limit)
        ->get();

    $html = '<a href="%1$s">%2$s</a>';
    if ($list) {
        $html = '<li><a href="%1$s">%2$s %3$s</a></li>';
    }

    $listHtml = '';
    foreach ($archives as $archive) {
        $url = route('archive.index', ['year' => $archive->year, 'month' => $archive->month]);
        $listHtml .= vsprintf($html, [$url, $archive->month_name, $archive->year]);
    }

    return $listHtml;
}

/**
 * @param boolean $list
 * @param int $limit
 *
 * @return string
 */
function get_categories($list = true, $limit = 10)
{
    $html = '<a href="%1$s">%2$s</a>';
    if ($list) {
        $html = '<li><a href="%1$s">%2$s</a></li>';
    }

    $categories = Category::query()->hasPosts()->limit($limit)->get();

    $listHtml = '';
    foreach ($categories as $category) {
        $url = route('category.index', [$category->slug]);
        $listHtml .= vsprintf($html, [$url, $category->name]);
    }

    return $listHtml;
}

/**
 * Filter through post body to find oEmbeddable links
 *
 * @param string $value
 *
 * @return string
 */
function oembed_body($value)
{
    $body = strip_tags($value);
    $re = '/^(http|https):\/\/(.)+(?=)$/im';
    preg_match_all($re, $body, $matches);
    if (empty($matches[0])) {
        return $value;
    }

    $links = array_map('trim', $matches[0]);
    $embedCode = [];
    $validLinks = [];
    $expiresAt = Carbon::now()->addMinutes(1440);
    foreach ($links as $link) {
        $oEmbedKey = 'oembed-' . md5($link);
        $html = '<div class="oembed">%s</div>';
        // cache markup
        $code = Cache::get($oEmbedKey);

        if ($code) {
            $validLinks[] = $link;
            $embedCode[] = vsprintf($html, [$code]);
        } else {
            try {
                $embed = Embed::create($link);
                $code = $embed->getCode();
                if ($code == null) {
                    continue;
                }
                $validLinks[] = $link;
                $embedCode[] = vsprintf($html, [$code]);
                Cache::put($oEmbedKey, $code, $expiresAt);
            } catch (InvalidUrlException $e) {
                Log::warning('oEmbed failed: ', ['code' => $e->getCode(), 'url' => $link]);
            }
        }
    }

    $value = str_replace($validLinks, $embedCode, $value);

    return $value;
}

/**
 * Display the post body, after formatting Markdown and oEmbed
 * @param App\Models\Post $post Our post object
 * @return string
 */
function get_post_body($post)
{
    $body = Markdown::convertToHtml($post->body);
    $body = oembed_body($body);

    return $body;
}


/**
 * Get the adjacent post object
 *
 * @param Post $post
 * @param bool $previous
 * @return Post|null
 */
function get_adjacent_post($post, $previous = true)
{
    $operator = $previous ? '<' : '>';
    $order = $previous ? 'DESC' : 'ASC';

    $adjacentPost = Post::query()->where('created_at', $operator, $post->created_at)
                                 ->orderBy('created_at', $order)
                                 ->limit(1)
                                 ->first();

    return $adjacentPost;
}


function get_adjacent_post_link($post, $previous)
{
    $adjacentPost = get_adjacent_post($post, $previous);

    if (isset($adjacentPost->title)) {
        $created_at = strtotime($adjacentPost->created_at);
        $link = route(
            'post.single',
            [
                date('Y', $created_at),
                date('m', $created_at),
                date('d', $created_at),
                $adjacentPost->slug,
            ]);
        return '<a href="' . $link . '">' . filter_var($adjacentPost->title, FILTER_SANITIZE_FULL_SPECIAL_CHARS) . '</a>';
    } else {
        return false;
    }
}

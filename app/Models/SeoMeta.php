<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Artesaos\SEOTools\Facades\SEOTools;

class SeoMeta extends Model
{
    use HasFactory, Uuids, SoftDeletes;
    
    protected $table = 'seo_meta';
    
    protected $fillable = [
        'page_type',
        'page_id',
        'title',
        'description',
        'image',
        'robots',
        'open_graph',
        'twitter',
        'structured_data',
        'alternate_links',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'page_id' => 'string',
        'open_graph' => 'array',
        'twitter' => 'array',
        'structured_data' => 'array',
        'alternate_links' => 'array',
    ];
    
    public function getPageNameAttribute()
{
    $models = [
        'post' => \App\Models\Post::class,
        'service' => \App\Models\Service::class,
        'project' => \App\Models\Project::class,
        'page' => \App\Models\Page::class,
        'faq' => \App\Models\Faq::class,
        'partner' => \App\Models\Partner::class,
        'client' => \App\Models\Client::class,
        'projectcategory' => \App\Models\ProjectCategory::class,
        'postcategory' => \App\Models\PostCategory::class,
    ];

    if (!isset($models[$this->page_type]) || !$this->page_id) {
        return null;
    }

    $model = $models[$this->page_type];

    return $model::find($this->page_id)?->name;
}

    
    public static function setSeoForPage($pageType, $pageId)
    {
        $seoMeta = self::where('page_type', $pageType)
                      ->where('page_id', $pageId)
                      ->first();

       $baseUrl = config('app.url') . '/storage';

        if ($seoMeta) {
            $title = $seoMeta->title;
            $description = $seoMeta->description;
            $image = $seoMeta->image ? self::makeAbsoluteUrl($seoMeta->image, $baseUrl) : config('seotools.meta.defaults.image');
            $robots = $seoMeta->robots ?? 'index, follow';
            $openGraph = $seoMeta->open_graph ?? [];
            $twitter = $seoMeta->twitter ?? [];
            $structuredData = $seoMeta->structured_data ?? [];
            $alternateLinks = $seoMeta->alternate_links ?? [];
        } else {
            $modelClass = [
                'post' => \App\Models\Post::class,
                'service' => \App\Models\Service::class,
                'project' => \App\Models\Project::class,
                'page' => \App\Models\Page::class,
                'faq' => \App\Models\Faq::class,
                'partner' => \App\Models\Partner::class,
                'client' => \App\Models\Client::class,
                'projectcategory' => \App\Models\ProjectCategory::class,
                'postcategory' => \App\Models\PostCategory::class,
            ][$pageType] ?? null;

            $model = $modelClass ? $modelClass::find($pageId) : null;

            if ($model) {
                $title = $model->title ?? config('seotools.meta.defaults.title');
                $description = $model->description ?? config('seotools.meta.defaults.description');
                $image = $model->image ? self::makeAbsoluteUrl($model->image, $baseUrl) : config('seotools.meta.defaults.image');
                $robots = 'index, follow';
                $openGraph = [];
                $twitter = [];
                $structuredData = [];
                $alternateLinks = [];
            } else {
                $title = config('seotools.meta.defaults.title');
                $description = config('seotools.meta.defaults.description');
                $image = config('seotools.meta.defaults.image');
                $robots = config('seotools.meta.defaults.robots');
                $openGraph = config('seotools.opengraph.defaults');
                $twitter = config('seotools.twitter.defaults');
                $structuredData = config('seotools.json-ld.defaults');
                $alternateLinks = [];
            }
        }

        // Apply Meta Tags (prevent title duplication)
        SEOTools::setTitle($title, false); // false prevents appending default title
        SEOTools::setDescription($description);
        SEOTools::setCanonical(url()->current());
        SEOTools::metatags()->addMeta('robots', $robots); // Single robots tag

        // Open Graph
        SEOTools::opengraph()->setTitle($title);
        SEOTools::opengraph()->setDescription($description);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->setType($pageType === 'post' ? 'article' : 'website');
        if ($image) {
            SEOTools::opengraph()->addImage($image);
        }
        foreach ($openGraph as $key => $value) {
            if ($value !== null) {
                if ($key === 'image' && $value) {
                    SEOTools::opengraph()->addImage(self::makeAbsoluteUrl($value, $baseUrl));
                } else {
                    SEOTools::opengraph()->addProperty($key, $value);
                }
            }
        }

        // Twitter Cards
        SEOTools::twitter()->setTitle($title);
        SEOTools::twitter()->setDescription($description);
        SEOTools::twitter()->setType('summary_large_image');
        if ($image) {
            SEOTools::twitter()->addImage($image); // Use custom image first
        }
        foreach ($twitter as $key => $value) {
            if ($value !== null) {
                if ($key === 'image' && $value) {
                    SEOTools::twitter()->addImage(self::makeAbsoluteUrl($value, $baseUrl));
                } elseif ($key === 'site') {
                    SEOTools::twitter()->setSite($value);
                } else {
                    SEOTools::twitter()->addValue($key, $value);
                }
            }
        }

        // Structured Data (JSON-LD)
        if (!empty($structuredData)) {
            SEOTools::jsonLd()->setTitle($title);
            SEOTools::jsonLd()->setDescription($description);
            SEOTools::jsonLd()->setType($pageType === 'post' ? 'Article' : 'WebPage');
            if ($image) {
                SEOTools::jsonLd()->addImage($image);
            }
            foreach ($structuredData as $key => $value) {
                if ($value !== null) {
                    if ($key === 'image' && $value) {
                        SEOTools::jsonLd()->addImage(self::makeAbsoluteUrl($value, $baseUrl));
                    } else {
                        SEOTools::jsonLd()->addValue($key, $value);
                    }
                }
            }
        }

        // Alternate Links
        if (!empty($alternateLinks)) {
            self::setAlternateLanguages($alternateLinks);
        }
    }

    /**
     * Convert relative URL to absolute URL
     *
     * @param string $path Relative or absolute URL
     * @param string $baseUrl Base URL to prepend
     * @return string Absolute URL
     */
    protected static function makeAbsoluteUrl(string $path, string $baseUrl): string
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path; // Already absolute
        }
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Add a single alternate language link
     *
     * @param string $lang Language code (e.g., 'en_US')
     * @param string $url URL of the alternate version
     * @return void
     */
    public static function addAlternateLanguage(string $lang, string $url)
    {
        if ($lang && $url) {
            SEOTools::metatags()->addMeta('alternate', $url, ['hreflang' => $lang]);
        }
    }

    /**
     * Add multiple alternate language links
     *
     * @param array $languages Array of ['lang' => 'language_code', 'url' => 'url'] pairs
     * @return void
     */
    public static function addAlternateLanguages(array $languages)
    {
        foreach ($languages as $link) {
            if (isset($link['lang']) && isset($link['url'])) {
                self::addAlternateLanguage($link['lang'], $link['url']);
            }
        }
    }

    /**
     * Set a single alternate language link (alias for add)
     *
     * @param string $lang Language code (e.g., 'en_US')
     * @param string $url URL of the alternate version
     * @return void
     */
    public static function setAlternateLanguage(string $lang, string $url)
    {
        self::addAlternateLanguage($lang, $url);
    }

    /**
     * Set multiple alternate language links
     *
     * @param array $languages Array of ['lang' => 'language_code', 'url' => 'url'] pairs
     * @return void
     */
    public static function setAlternateLanguages(array $languages)
    {
        self::addAlternateLanguages($languages);
    }
}
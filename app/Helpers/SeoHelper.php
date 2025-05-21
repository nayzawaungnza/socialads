<?php
use App\Models\SeoMeta;

if (!function_exists('setPageSeo')) {
    function setPageSeo($pageType, $pageId = null)
    {
        $seoMeta = SeoMeta::where('page_type', $pageType)
            ->when($pageId, fn ($query) => $query->where('page_id', $pageId))
            ->first();

        if ($seoMeta) {
            $seoMeta->setSeoMeta();
        } else {
            // Fallback SEO
            SEOTools::setTitle('Default Site Title');
            SEOTools::setDescription('Default description for the website.');
            SEOTools::setCanonical(url()->current());
            SEOTools::addMeta('robots', 'index, follow');
        }
    }
}

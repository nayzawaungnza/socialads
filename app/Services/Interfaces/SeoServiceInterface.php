<?php

namespace App\Services\Interfaces;

use App\Models\SeoMeta;

interface SeoServiceInterface
{
    public function createSeoMeta(array $data): SeoMeta;
    public function updateSeoMeta(SeoMeta $seoMeta, array $data): SeoMeta;
    public function deleteSeoMeta(SeoMeta $seoMeta): bool;
    public function getSeoMeta(string $pageType, string $pageId): ?SeoMeta;
}
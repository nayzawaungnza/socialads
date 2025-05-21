<?php
namespace App\Services;

use App\Models\SeoMeta;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Backend\SeoRepository;
use App\Services\Interfaces\SeoServiceInterface;

class SeoService implements SeoServiceInterface
{
   protected $seoRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(SeoRepository $seoRepository)
    {
        $this->seoRepository = $seoRepository;
    }
    
     public function createSeoMeta(array $data): SeoMeta
    {
        DB::beginTransaction();
        try {
            //dd($data);
            $seo = $this->seoRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('SEO Creation Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to create seo'); 
        }
        DB::commit();
        return $seo;
    }
    
     public function updateSeoMeta(SeoMeta $seoMeta, array $data): SeoMeta
    {
         DB::beginTransaction();
        try {
            $seo = $this->seoRepository->update($seoMeta,$data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('SEO Update Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to seo update'); 
        }
        DB::commit();
        return $seo;
    }
    
     public function deleteSeoMeta(SeoMeta $seoMeta): bool
    {
        DB::beginTransaction();
        try {
            $seo = $this->seoRepository->destroy($seoMeta);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('SEO deletion Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to delete seo'); 
        }
        DB::commit();
        return $seo;
    }
    
    public function getSeoMeta(string $pageType, string $pageId): ?SeoMeta
    {
        return $this->seoRepository->getSeoMeta($pageType, $pageId);
    }
}

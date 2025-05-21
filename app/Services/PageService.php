<?php

namespace App\Services;

use Exception;
use App\Models\Page;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Backend\PageRepository;
use App\Services\Interfaces\PageServiceInterface;

class PageService implements PageServiceInterface
{
    protected $pageRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function getPages($status = 1)
    {
    return $this->pageRepository->getPages($status);
    }
    public function getPage($slug)
    {
        return $this->pageRepository->getPage($slug);
    }
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $page = $this->pageRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Post Creation Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to create page'); 
        }
        DB::commit();
        return $page;
    }
    public function update(Page $page, array $data)
    {
        DB::beginTransaction();
        try {
            $page = $this->pageRepository->update($page,$data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Page Update Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to page update'); 
        }
        DB::commit();
        return $page;
    }
    public function destroy(Page $page)
    {
        DB::beginTransaction();
        try {
            $page = $this->pageRepository->destroy($page);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Page deletion Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to delete page'); 
        }
        DB::commit();
        return $page;
    }
    public function changeStatus(Page $page)
    {
        DB::beginTransaction();
        try {
            $page = $this->pageRepository->changeStatus($page);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Page Status Change Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to change page status'); 
        }
        DB::commit();
        return $page;
    }
    public function getPageEloquent()
    {
        return $this->pageRepository->getPageEloquent();
    }
}
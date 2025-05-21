<?php

namespace App\Services;

use Exception;
use App\Models\Faq;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Backend\FaqRepository;
use App\Services\Interfaces\FaqServiceInterface;

class FaqService implements FaqServiceInterface
{
    protected $faqRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(FaqRepository $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    public function getFaqs($status = 1)
    {
        return $this->faqRepository->getFaqs( $status);
    }
    public function getFaq($id)
    {

    }
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $faq = $this->faqRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Faq Creation Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to create faq'); 
        }
        DB::commit();
        return $faq;
    }
    public function update(Faq $faq, array $data)
    {
        DB::beginTransaction();
        try {
            $faq = $this->faqRepository->update($faq,$data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Faq Update Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to faq update'); 
        }
        DB::commit();
        return $faq;
    }
    public function destroy(Faq $faq)
    {
        DB::beginTransaction();
        try {
            $faq = $this->faqRepository->destroy($faq);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('faq deletion Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to delete faq'); 
        }
        DB::commit();
        return $faq;
    }
   
    public function getFaqEloquent()
    {
        return $this->faqRepository->getFaqEloquent();
    }
}
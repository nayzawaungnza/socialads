<?php

namespace App\Services;

use Exception;
use App\Models\Partner;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Backend\PartnerRepository;
use App\Services\Interfaces\PartnerServiceInterface;

class PartnerService implements PartnerServiceInterface
{
    protected $partnerRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(PartnerRepository $partnerRepository)
    {
        $this->partnerRepository = $partnerRepository;
    }

    public function getPartners($status = 1)
    {
    return $this->partnerRepository->getPartners($status);
    }
    public function getPartner($id)
    {

    }
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $partner = $this->partnerRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Partner Creation Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to create Partner'); 
        }
        DB::commit();
        return $partner;
    }
    public function update(Partner $partner, array $data)
    {
        DB::beginTransaction();
        try {
            $partner = $this->partnerRepository->update($partner,$data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Partner Update Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to Partner update'); 
        }
        DB::commit();
        return $partner;
    }
    public function destroy(Partner $partner)
    {
        DB::beginTransaction();
        try {
            $partner = $this->partnerRepository->destroy($partner);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Partner deletion Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to delete Partner'); 
        }
        DB::commit();
        return $partner;
    }
    public function changeStatus(Partner $partner)
    {
        DB::beginTransaction();
        try {
            $partner = $this->partnerRepository->changeStatus($partner);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('Partner Status Change Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to change Partner status'); 
        }
        DB::commit();
        return $partner;
    }
    public function getPartnerEloquent()
    {
        return $this->partnerRepository->getPartnerEloquent();
    }
}
<?php

namespace App\Services\Interfaces;

use App\Models\Partner;

interface PartnerServiceInterface
{
    public function getPartners($status = 1);
    public function getPartner($id);
    public function create(array $request);
    public function update(Partner $partner, array $request);
    public function destroy(Partner $partner);
    public function changeStatus(Partner $partner);
    public function getPartnerEloquent();
}
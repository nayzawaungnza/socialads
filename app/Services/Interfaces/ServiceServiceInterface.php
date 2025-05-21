<?php

namespace App\Services\Interfaces;

use App\Models\Service;

interface ServiceServiceInterface
{
    public function getServices($status = null);
    public function getService($slug);
    public function create(array $request);
    public function update(Service $service, array $request);
    public function destroy(Service $service);
    public function changeStatus(Service $service);
    public function getServiceEloquent();
}
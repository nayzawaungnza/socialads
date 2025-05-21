<?php

namespace App\Services\Interfaces;

use App\Models\Faq;

interface FaqServiceInterface
{
    public function getFaqs($status = 1);
    public function getFaq($id);
    public function create(array $request);
    public function update(Faq $faq, array $request);
    public function destroy(Faq $faq);
    public function getFaqEloquent();
}
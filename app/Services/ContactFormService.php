<?php
namespace App\Services;

use App\Repositories\Backend\ContactFormRepository;
use App\Services\Interfaces\ContactFormServiceInterface;
use App\Models\ContactForm;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactFormService implements ContactFormServiceInterface
{
    protected $contactRepository;

    public function __construct(ContactFormRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function store(array $data): ContactForm
    {
        DB::beginTransaction();
        try {
            $contactform = $this->contactRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('inbox Creation Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to create contact form inbox'); 
        }
        DB::commit();

        return $contactform;
    }

    public function getAll()
    {
        return $this->contactRepository->getAll();
    }

    public function markAsRead($id)
    {
         DB::beginTransaction();
        try {
            $contactform = $this->contactRepository->updateStatus($id, 'read');
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error('inbox read Error:'.$exc->getMessage());
            throw new InvalidArgumentException('Unable to mark read inbox'); 
        }
        DB::commit();

        return $contactform;
        
    }
}

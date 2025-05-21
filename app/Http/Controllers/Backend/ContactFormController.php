<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ContactFormService;
use App\Models\ContactForm;
class ContactFormController extends Controller
{
    protected $contactService;

    public function __construct(ContactFormService $contactService)
    {
        $this->contactService = $contactService;
    }
    
    public function index()
    {
        $contacts = $this->contactService->getAll();

        return view('backend.inbox.index', compact('contacts'));
    }

    public function markAsRead($id)
    {
        // Call the service method to mark the contact as read
        $updated = $this->contactService->markAsRead($id);
    
        // Check if the update was successful
        if ($updated) {
            return response()->json([
                'success' => true,
                'message' => 'Contact marked as read', // Correct the message string
                'data' => $updated // Return the updated contact form (not $contact)
            ]);
        }
    
        return response()->json(['error' => 'Contact not found'], 404);
    } 
    
    public function show(ContactForm $contactform) {
        //dd($contactform->toArray());
        return view('backend.inbox.show', compact('contactform'));
    }
    
}

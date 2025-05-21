<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ContactFormService;
use App\Services\UserService;
use App\Http\Requests\ContactForm\ContactFormRequest;
use Illuminate\Support\Facades\Validator;

class ContactFormController extends Controller
{
    protected $contactService;
    protected $userService;

    public function __construct(ContactFormService $contactService, UserService $userService)
    {
        $this->contactService = $contactService;
        $this->userService = $userService;
    }

    public function store(ContactFormRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // Check subscription readiness if subscribe is checked
            if ($validatedData['subscribe'] ?? false) {
                // Validate subscription eligibility (e.g., email uniqueness)
                $subscriptionValidator = Validator::make($validatedData, [
                    'email' => 'required|email|unique:users,email', // Adjust table name if different
                ]);

                if ($subscriptionValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Subscription check failed',
                        'errors' => $subscriptionValidator->errors()->all()
                    ], 422);
                }
            }

            // Store contact form data
            $contact = $this->contactService->store($validatedData);

            // Handle subscription if checked (after contact form is stored)
            if ($validatedData['subscribe'] ?? false) {
                try {
                    $this->userService->subscribe($validatedData);
                } catch (\Exception $e) {
                    \Log::error('Subscription failed after contact form submission', [
                        'error' => $e->getMessage(),
                        'data' => $validatedData
                    ]);
                    // Optionally include a warning in the response
                    return response()->json([
                        'success' => true,
                        'message' => 'Thank you! We’ll get back to you within 24 hours. Note: Subscription failed.',
                        'data' => $contact,
                        'subscription_error' => 'Unable to subscribe at this time.'
                    ], 201);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Thank you! We’ll get back to you within 24 hours',
                'data' => $contact
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
                'errors' => [$e->getMessage()]
            ], 500);
        }
    }
}

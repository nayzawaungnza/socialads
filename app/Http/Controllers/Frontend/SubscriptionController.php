<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use App\Mail\SubscriptionSuccessMail;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        
    }
    
    public function subscribe(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email', // Assuming table is 'users'
            'first_name' => 'nullable|string|max:255', // Optional, to match form
            'last_name' => 'nullable|string|max:255',  // Optional, to match form
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->all(), // Return all errors
            ], 400);
        }

        // Prepare data
        $data = $request->all();

        // Extract name from email if first_name and last_name aren't provided
        if (!isset($data['first_name']) && !isset($data['last_name'])) {
            try {
                $emailName = explode('@', $request->email)[0];
                $name = ucwords(str_replace(['.', '_', '-'], ' ', $emailName));
                $data['name'] = $name;
            } catch (\Exception $e) {
                $data['name'] = 'Subscriber'; // Fallback if email parsing fails
            }
        } else {
            $data['name'] = trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? ''));
        }

        // Create subscriber
        try {
            $subscriber = $this->userService->subscribe($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create subscriber: ' . $e->getMessage(),
            ], 500);
        }

        // Send email notification to subscriber
        try {
            Mail::to($subscriber->email)->send(new SubscriptionSuccessMail($subscriber->name, $subscriber->email));
        } catch (\Exception $e) {
            // Log the error but don't fail the response
            \Log::error('Failed to send subscription email', ['error' => $e->getMessage()]);
        }

        return response()->json([
            'success' => true,
            'message' => "Thank you, {$subscriber->name}, for subscribing!",
        ], 201);
    }

    
}

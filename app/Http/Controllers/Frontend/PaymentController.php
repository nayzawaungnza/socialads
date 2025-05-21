<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Transaction;
use App\Enums\PaymentStatusEnum;
use App\Services\CourseServices;
use App\Services\EnrollmentService;
use App\Http\Controllers\Controller;
use App\Services\PaymentMethodService;

class PaymentController extends Controller
{
    protected $courseService;
    protected $enrollmentService;

    protected $paymentMethodService;

    public function __construct(CourseServices $courseService, EnrollmentService $enrollmentService, PaymentMethodService $paymentMethodService)
    {
        $this->courseService = $courseService;
        $this->enrollmentService = $enrollmentService;
        $this->paymentMethodService = $paymentMethodService;
    }

    public function status($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);

        if ($transaction->payment_status === PaymentStatusEnum::SUCCESS) {
            
            return redirect()->route('frontend.courses.detail', $transaction->course->slug)
                ->with('success', 'Payment successful! You are now enrolled.');
        }

        return redirect()->route('frontend.courses.detail', $transaction->course->slug)
            ->with('error', 'Payment failed. Please try again.');
    }

}
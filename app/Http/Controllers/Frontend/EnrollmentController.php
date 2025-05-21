<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Services\CourseServices;
use App\Services\EnrollmentService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\PaymentMethodService;

class EnrollmentController extends Controller
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

    public function enroll($slug){
        $url = route('course.enroll.now', $slug);
        $course = $this->courseService->findBySlug($slug);
        $paymentMethods = $this->paymentMethodService->getPaymentMethods();
        return view('frontend.enroll', compact('course', 'paymentMethods', 'url'));
    }

    public function enrollnow($slug, Request $request)
    {
        //dd($request->all(), $slug, auth()->id());
        try {
            // Fetch the course using the slug
            $course = $this->courseService->findBySlug($slug);

            if (!$course) {
                return redirect()->route('frontend.courses.detail', $slug)
                    ->with('error', 'Course not found.');
            }

            // Get the authenticated student ID
            $studentId = auth()->id();

            if (!$studentId) {
                return redirect()->route('frontend.login')
                    ->with('error', 'Please login to enroll in the course.');
            }

            if ($course->price == 0) {
                // Free course enrollment
                $this->enrollmentService->enrollFreeCourse($studentId, $course->id);

                return redirect()->route('frontend.courses.detail', $course->slug)
                    ->with('success', 'You are successfully enrolled in the free course!');
            }

            // Paid course enrollment
            $transaction = $this->enrollmentService->enrollPaidCourse($studentId, $course, $request->all());

            return redirect()->route('frontend.payment.status', $transaction->id)
                ->with('info', 'Payment is under review.');

        } catch (InvalidArgumentException $e) {
            // Handle known issues such as already enrolled or course validation
            return redirect()->route('frontend.courses.detail', $slug)
                ->with('error', $e->getMessage());
        } catch (Exception $e) {
            // Log unexpected errors
            Log::error("Error enrolling student in course: " . $e->getMessage());

            return redirect()->route('frontend.courses.detail', $slug)
                ->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }


}
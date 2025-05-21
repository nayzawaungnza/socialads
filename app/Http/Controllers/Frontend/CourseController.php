<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Course;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;
use App\Services\CourseServices;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    protected $courseService;
    protected $enrollmentService;

    public function __construct(CourseServices $courseService, EnrollmentService $enrollmentService)
    {
        $this->courseService = $courseService;
        $this->enrollmentService = $enrollmentService;
    }

    public function index(Request $request, $slug)
    {
        //dd($request->all(), $slug, auth('admin')->user());
        // Fetch the course using the slug
        $course = $this->courseService->findBySlug($slug);
    
        // Initialize button defaults
        $buttonText = 'Enroll Now';
        $buttonLink = route('course.enroll', ['slug' => $course->slug]);
        //$enrollment = auth('student')->user()->enrollments()->where('course_id', $course->id)->first();
        //dd($enrollment);
        // Check if the user is authenticated and a student
        if (auth('student')->check() && auth('student')->user() ) {
            $enrollment = auth('student')->user()->enrollments()->where('course_id', $course->id)->first();
    
            // Update button based on enrollment status
            if ($enrollment) {
                $buttonText = match ($enrollment->status) {
                    1 => 'Enrollment Pending',
                    2 => 'Already Enrolled',
                    default => $buttonText,
                };
                $buttonLink = $enrollment->status === 1 || $enrollment->status === 2 ? '#' : $buttonLink;
            }
        }

        if (auth('admin')->check() && auth('admin')->user() ) {
            $buttonText = 'You are an Admin, You can not enroll';
            $buttonLink = '#';
        }

        if (auth('teacher')->check() && auth('teacher')->user() ) {
            $buttonText = 'You are a Teacher, You can not enroll';
            $buttonLink = '#';
        }

    
        //dd($buttonText, $buttonLink);
    
        return view('frontend.course', compact('course', 'buttonText', 'buttonLink'));
    }
    
}
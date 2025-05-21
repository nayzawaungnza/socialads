<?php

namespace App\Listeners;

use App\Events\StudentEnrolled;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnrollmentConfirmationMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEnrollmentNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StudentEnrolled $event): void
    {
        $student = $event->enrollment->student;
        $course = $event->enrollment->course;

        Mail::to($student->email)->send(new EnrollmentConfirmationMail($student, $course));
    }
}
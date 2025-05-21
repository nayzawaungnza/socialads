<?php
namespace App\Repositories\Backend;

use App\Repositories\BaseRepository;
use Carbon\Carbon;
use App\Models\ContactForm;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactFormNotification;
use Illuminate\Support\Facades\Mail;
use Exception;

class ContactFormRepository extends BaseRepository
{
    
    public function model()
    {
        return ContactForm::class;
    }
    
    
    public function create(array $data): ContactForm
    {
        Log::info('Creating ContactForm', ['data' => $data]);
        
        $full_name = trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? ''));
        $contactform = ContactForm::create([
            'name'        => $data['name'] ?? $full_name,
            'email'       => $data['email'],
            'phone'       => $data['phone_number'] ?? null, // Updated to match form field
            'subject'     => $data['subject'] ?? null,
            'type'        => $data['type'] ?? 'general',
            'favourite'   => $data['favourite'] ?? false,
            'archive'     => $data['archive'] ?? false,
            'trash'       => $data['trash'] ?? false,
            'message'     => $data['message'] ?? null,
            'company_name' => $data['company_name'] ?? null,
            'service_id'  => $data['service_id'] ?? null,
            'status'      => $data['status'] ?? 'new',
        ]);
    
         $activity_data['subject'] = $contactform;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.CREATED_EVENT_NAME');
        $activity_data['description'] = sprintf('New Contact Inbox: %s.', $contactform->email);
        saveActivityLog($activity_data);
    
        $adminEmail = ['hello@socialadsdigital.com'];
    $ccRecipients = ['nayzawaung.nza750@gmail.com'];
    $bccRecipients = ['nayzawaung.developer750@gmail.com'];

    try {
        Log::info('Attempting to send contact form notification', [
            'to' => $adminEmail,
            'cc' => $ccRecipients,
            'bcc' => $bccRecipients
        ]);
        
        Mail::to($adminEmail)
            ->cc($ccRecipients)
            ->bcc($bccRecipients)
            ->send(new ContactFormNotification($contactform));
        
        Log::info('Contact form notification sent successfully');
    } catch (\Exception $e) {
        Log::error('Failed to send contact form notification', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'data' => $data
        ]);
        // Optionally rethrow if you want to fail the creation
        // throw $e;
    }
    
        return $contactform;
    }


    public function getAll()
    {
        return ContactForm::orderBy('created_at', 'desc')->get();
    }

    public function updateStatus($id, $status)
    {
        // Retrieve the ContactForm instance (this will be an Eloquent model, not just a number of affected rows)
    $contactform = ContactForm::findOrFail($id);

    // Update the ContactForm instance
    $contactform->update([
        'status' => $status,
        'updated_by' => auth()->id(),
        'mark_as_read' => true,
        'updated_at' => now(),
    ]);

    // Save activity in the activity log
    $activity_data['subject'] = $contactform;
    $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');

    $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.CONTACTFORM'))
        ? 'User'
        : class_basename(auth()->user()->getModel());

    // Ensure contactform is an actual model instance to avoid the error
    $activity_data['description'] = sprintf(
        '%s(%s) marked as Read Inbox (%s).',
        $model_type,
        auth()->user()->name,
        $contactform->name // Now this will work correctly because $contactform is an Eloquent model
    );

    // Log the activity
    saveActivityLog($activity_data);

    return $contactform;
    }
    
    // Mark a contact as favourite
    public function markAsFavourite($id): ContactForm
    {
        $contact = ContactForm::findOrFail($id);
        $contact->favourite = !$contact->favourite;  // Toggle the favourite status
        $contact->updated_by = auth()->user()->id;  // Update the user who made the change
        $contact->save();

        return $contact;
    }

    // Mark a contact as archived
    public function markAsArchived($id): ContactForm
    {
        $contact = ContactForm::findOrFail($id);
        $contact->archive = !$contact->archive;  // Toggle the archive status
        $contact->updated_by = auth()->user()->id;  // Update the user who made the change
        $contact->save();

        return $contact;
    }

    // Mark a contact as trashed
    public function markAsTrashed($id): ContactForm
    {
        $contact = ContactForm::findOrFail($id);
        $contact->trash = !$contact->trash;  // Toggle the trash status
        $contact->updated_by = auth()->user()->id;  // Update the user who made the change
        $contact->save();

        return $contact;
    }
    
}

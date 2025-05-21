<?php

namespace App\Repositories\Backend;

use App\Models\Faq;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Backend\ImageRepository;

class FaqRepository extends BaseRepository
{
    public function model()
    {
        return Faq::class;
    }

    public function getFaqs($status = 1)
    {
         return $this->model->where('status', $status)
                            ->orderBy('created_at', 'desc')
                            ->with('services')
                            ->with('updatedBy')
                            ->with('createdBy')
                            ->get();
                            
        
    }
    public function getFaq($id)
    {
        return $this->model::query()
            ->with('services')
            ->with('updatedBy')
            ->with('createdBy')
            ->findOrFail($id);
    }
    public function create(array $data)
    {
       // dd(auth()->user()->id);
        $faq = Faq::create([
        'question' => $data['question'],
        'answer' => $data['answer'],
        'created_by' => auth()->user()->id,
        ]);

       // Sync service_ids to the faq_service pivot table
        if (isset($data['service_ids']) && is_array($data['service_ids'])) {
            $faq->services()->sync($data['service_ids']); // Sync array of service IDs
        }
        
        // save activity in activitylog
        $activity_data['subject'] = $faq;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.CREATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.FAQ'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) create faq (%s).', $model_type, auth()->user()->name, $faq->name);
        saveActivityLog($activity_data);

        return $faq;
    }
    public function update(Faq $faq, array $data)
    {
      
        
       $faq->update([
                'question' => $data['question'] ?? $faq->question,
                'answer' => $data['answer'] ?? $faq->answer,
                'status' => isset($data['status']) ? $data['status'] : $faq->status,
                'updated_by' => auth()->user()->id
        ]);

        // Sync service_ids to the faq_service pivot table
        if (isset($data['service_ids']) && is_array($data['service_ids'])) {
            $faq->services()->sync($data['service_ids']); // Sync array of service IDs
        }
        
        
        // save activity in activitylog
        $activity_data['subject'] = $faq;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.FAQ'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update faq (%s).', $model_type, auth()->user()->name, $faq->name);
        saveActivityLog($activity_data);

        return $faq;

    }
    public function destroy(Faq $faq)
    {
        $faq->services()->detach();

        $deleted = $this->deleteById($faq->id);
        if ($deleted) {
            $faq->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $faq;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.DELETED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.FAQ'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) delete faq (%s).', $model_type, auth()->user()->name, $faq->name);
        saveActivityLog($activity_data);
    }
    
    public function getFaqEloquent()
    {
        return Faq::query()
            ->with('services')
            ->with('updatedBy')
            ->with('createdBy');
    }
}
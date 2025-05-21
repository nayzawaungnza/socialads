<?php

namespace App\Repositories\Backend;

use App\Models\SeoMeta;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Backend\ImageRepository;

class SeoRepository extends BaseRepository
{
    public function model()
    {
        return SeoMeta::class;
    }

    public function getSeoMeta(string $pageType, string $pageId)
    {
        return $this->model->where('page_type', $pageType)
            ->where('page_id', $pageId)
            ->first();
    }
    
    public function create(array $data)
    {
        // Handle file uploads first
        $data = $this->handleFileUploads($data);
        
        $seoMeta = SeoMeta::create([
            'page_type' => $data['page_type'],
            'page_id' => $data['page_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $data['image'] ?? null,
            'robots' => $data['robots'],
            'open_graph' => $data['open_graph'] ?? null,
            'twitter' => $data['twitter'] ?? null,
            'structured_data' => $data['structured_data'] ?? null,
            'alternate_links' => $data['alternate_links'] ?? null,
            'status' => $data['status'] ?? 1,
            'created_by' => auth()->id(),
        ]);
        
        // save activity in activitylog
        $activity_data['subject'] = $seoMeta;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.CREATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) create seo (%s).', $model_type, auth()->user()->name, $seoMeta->title); // Changed $seoMeta->name to $seoMeta->title
        saveActivityLog($activity_data);

        return $seoMeta; // Fixed variable name from $service to $seoMeta
    }

    public function update(SeoMeta $seoMeta, array $data)
    {
        $data = $this->handleFileUploads($data, $seoMeta);
        
        $seoMeta->update([
            'page_type' => $data['page_type'] ?? $seoMeta->page_type,
            'page_id' => $data['page_id'] ?? $seoMeta->page_id,
            'title' => $data['title'] ?? $seoMeta->title,
            'description' => $data['description'] ?? $seoMeta->description,
            'image' => $data['image'] ?? $seoMeta->image,
            'robots' => $data['robots'] ?? $seoMeta->robots,
            'open_graph' => $data['open_graph'] ?? $seoMeta->open_graph,
            'twitter' => $data['twitter'] ?? $seoMeta->twitter,
            'structured_data' => $data['structured_data'] ?? $seoMeta->structured_data,
            'alternate_links' => $data['alternate_links'] ?? $seoMeta->alternate_links,
            'status' => $data['status'] ?? $seoMeta->status,
            'updated_by' => auth()->id()
        ]);

        // save activity in activitylog
        $activity_data['subject'] = $seoMeta;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update seo (%s).', $model_type, auth()->user()->name, $seoMeta->title); // Changed $seoMeta->name to $seoMeta->title
        saveActivityLog($activity_data);

        return $seoMeta;
    }

    public function destroy(SeoMeta $seoMeta)
    {
        $this->deleteFiles($seoMeta); // Add file deletion before soft delete
        $deleted = $this->deleteById($seoMeta->id);
        if ($deleted) {
            $seoMeta->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $seoMeta;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.DELETED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.USER'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) delete seo(%s).', $model_type, auth()->user()->name, $seoMeta->title); // Changed $seoMeta->name to $seoMeta->title
        saveActivityLog($activity_data);

        return $deleted;
    }
    
    protected function handleFileUploads(array $data, ?SeoMeta $seoMeta = null): array
    {
        // Handle main image
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($seoMeta && $seoMeta->image) {
                Storage::disk('public')->delete($seoMeta->image);
            }
            $data['image'] = $data['image']->store('seo/images', 'public');
        } elseif ($seoMeta) {
            $data['image'] = $seoMeta->image;
        }

        // Handle open graph image
        if (isset($data['open_graph']['image']) && $data['open_graph']['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($seoMeta && isset($seoMeta->open_graph['image'])) {
                Storage::disk('public')->delete($seoMeta->open_graph['image']);
            }
            $data['open_graph']['image'] = $data['open_graph']['image']->store('seo/open-graph', 'public');
        } elseif ($seoMeta && isset($seoMeta->open_graph['image'])) {
            $data['open_graph']['image'] = $seoMeta->open_graph['image'];
        }

        // Handle twitter image
        if (isset($data['twitter']['image']) && $data['twitter']['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($seoMeta && isset($seoMeta->twitter['image'])) {
                Storage::disk('public')->delete($seoMeta->twitter['image']);
            }
            $data['twitter']['image'] = $data['twitter']['image']->store('seo/twitter', 'public');
        } elseif ($seoMeta && isset($seoMeta->twitter['image'])) {
            $data['twitter']['image'] = $seoMeta->twitter['image'];
        }

        // Handle structured data image
        if (isset($data['structured_data']['image']) && $data['structured_data']['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($seoMeta && isset($seoMeta->structured_data['image'])) {
                Storage::disk('public')->delete($seoMeta->structured_data['image']);
            }
            $data['structured_data']['image'] = $data['structured_data']['image']->store('seo/structured-data', 'public');
        } elseif ($seoMeta && isset($seoMeta->structured_data['image'])) {
            $data['structured_data']['image'] = $seoMeta->structured_data['image'];
        }

        return $data;
    }

    protected function deleteFiles(SeoMeta $seoMeta): void
    {
        if ($seoMeta->image) {
            Storage::disk('public')->delete($seoMeta->image);
        }

        if (isset($seoMeta->open_graph['image'])) {
            Storage::disk('public')->delete($seoMeta->open_graph['image']);
        }

        if (isset($seoMeta->twitter['image'])) {
            Storage::disk('public')->delete($seoMeta->twitter['image']);
        }

        if (isset($seoMeta->structured_data['image'])) {
            Storage::disk('public')->delete($seoMeta->structured_data['image']);
        }
    }
}
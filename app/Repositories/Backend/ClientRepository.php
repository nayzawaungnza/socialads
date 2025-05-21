<?php

namespace App\Repositories\Backend;

use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Backend\ImageRepository;

class ClientRepository extends BaseRepository
{
    public function model()
    {
        return Client::class;
    }

    public function getClients($status = 1)
    {
        return $this->model->where('status', $status)
                            ->orderBy('created_at', 'desc')
                            ->get();
    }
    public function getClient($id)
    {

    }
    public function create(array $data)
    {
        $path_name = "clients";
        $client = Client::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null, // Use null coalescing for optional fields
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'phone' => $data['phone'] ?? null,
            'company' => $data['company'] ?? null,
            'url' => $data['url'] ?? null,
            'socials' => [
                'facebook' => $data['facebook'] ?? null,
                'telegram' => $data['telegram'] ?? null,
                'youtube' => $data['youtube'] ?? null,
                'linkedIn' => $data['linkedIn'] ?? null,
                'twitter' => $data['twitter'] ?? null,
                'tiktok' => $data['tiktok'] ?? null,
            ],
            'excerpt' => $data['excerpt'] ?? null,
            'status' => $data['status'] ?? 1, // Simplified ternary
            'created_by' => auth()->id(), // Use auth()->id() for brevity
        ]);

        if(isset($data['default_image']))
        {
            $imageRepository = new ImageRepository();
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.CLIENT'));
            $image_data['resourceable_type'] = 'Client';
            $image_data['resourceable_id'] = $client->id;
            $image_data['image_url'] = $path_name . '/' .$image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $file) {
                $image_path = $imageRepository->create_file($file, $path_name, config('constants.LABEL_NAME.CLIENT'));
                $image_data['resourceable_type'] = 'Client';
                $image_data['resourceable_id'] = $client->id;
                $image_data['image_url'] = $path_name . '/' .$image_path;
                $image_data['is_default'] = config('constants.STATUS_FALSE');
                $image = $imageRepository->create($image_data);
            }
        }

        
        // save activity in activitylog
        $activity_data['subject'] = $client;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.CREATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.CLIENT'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) create Client (%s).', $model_type, auth()->user()->name, $client->name);
        saveActivityLog($activity_data);

        return $client;
    }
    public function update(Client $client, array $data)
    {
        $path_name = 'clients';
        $imageRepository = new ImageRepository();

        
        $client->update([
            'name' => $data['name'] ?? $client->name, // Fallback to existing value if not provided
            'description' => $data['description'] ?? $client->description,
            'email' => $data['email'] ?? $client->email,
            'address' => $data['address'] ?? $client->address,
            'phone' => $data['phone'] ?? $client->phone,
            'company' => $data['company'] ?? $client->company,
            'url' => $data['url'] ?? $client->url,
            'socials' => [
                'facebook' => $data['facebook'] ?? $client->socials['facebook'] ?? null,
                'telegram' => $data['telegram'] ?? $client->socials['telegram'] ?? null,
                'youtube' => $data['youtube'] ?? $client->socials['youtube'] ?? null,
                'linkedIn' => $data['linkedIn'] ?? $client->socials['linkedIn'] ?? null,
                'twitter' => $data['twitter'] ?? $client->socials['twitter'] ?? null,
                'tiktok' => $data['tiktok'] ?? $client->socials['tiktok'] ?? null,
            ],
            'excerpt' => $data['excerpt'] ?? $client->excerpt,
            'status' => $data['status'] ?? $client->status, // Fallback to existing value
            'updated_by' => auth()->id(), // Use updated_by instead of created_by
        ]);


        if(isset($data['default_image']) && $data['default_image'])
        {       logger($client->default_image);
                if($client->default_image){
                $previous_default_image = $client->default_image;
                logger($previous_default_image);
                $medium_img = Str::replaceLast('.', config('constants.IMAGE_FILE_NAME.MEDIUM'), $previous_default_image->image_url);
                Storage::disk('public')->delete($path_name . '/' . $medium_img);
                Storage::disk('public')->delete($path_name . '/' . $previous_default_image->image_url);
                $imageRepository->destroy($previous_default_image);
                }
        }

        if (isset($data['default_image'])) {
            $image_path = $imageRepository->create_file($data['default_image'], $path_name, config('constants.LABEL_NAME.CLIENT'));
            logger($image_path);
            $image_data['resourceable_type'] = 'Client';
            $image_data['resourceable_id'] = $client->id;
            $image_data['image_url'] = $path_name . '/' . $image_path;
            $image_data['is_default'] = config('constants.STATUS_TRUE');
            $image = $imageRepository->create($image_data);
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $key => $file) {
                $image_path = $imageRepository->create_file($file, $path_name, config('constants.LABEL_NAME.CLIENT'));
                $image_data['resourceable_type'] = 'Client';
                $image_data['resourceable_id'] = $client->id;
                $image_data['image_url'] = $path_name . '/' .$image_path;
                $image_data['is_default'] = config('constants.STATUS_FALSE');
                $image = $imageRepository->create($image_data);
            }
        }
        
        // save activity in activitylog
        $activity_data['subject'] = $client;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.CLIENT'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update Client (%s).', $model_type, auth()->user()->name, $client->name);
        saveActivityLog($activity_data);

        return $client;

    }
    public function destroy(Client $client)
    {
        $deleted = $this->deleteById($client->id);
        if ($deleted) {
            $client->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $client;
        $activity_data['event'] = config('constants.ACTIVITY_LOG.DELETED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.CLIENT'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) delete Client (%s).', $model_type, auth()->user()->name, $client->name);
        saveActivityLog($activity_data);
    }
    public function changeStatus(Client $client)
    {
        if ($client->status == 0) {
            $client->status = 1;
        } else {
            $client->status = 0;
        }
        if ($client->isDirty()) {
            $client->updated_by = auth()->user()->id;
            $client->save();
        }

        // save activity in activitylog
        $activity_data['subject'] = $client->refresh();
        $activity_data['event'] = config('constants.ACTIVITY_LOG.UPDATED_EVENT_NAME');
        $model_type = (class_basename(auth()->user()->getModel()) === config('constants.LABEL_NAME.CLIENT'))
            ? 'User'
            : class_basename(auth()->user()->getModel());
        $activity_data['description'] = sprintf('%s(%s) update client (%s) status.', $model_type, auth()->user()->name, $client->name);
        saveActivityLog($activity_data);
        return $client;
    }
    public function getClientEloquent()
    {
        return Client::query()
            ->with('updatedBy')
            ->with('createdBy')
            ->with('default_image');
    }
}
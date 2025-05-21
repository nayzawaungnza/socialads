<?php

namespace App\Http\Controllers\Backend;

use DataTables;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Enums\PostStatusEnum;
use App\Services\ClientService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Client\CreateClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;

class ClientController extends Controller
{
    protected $clientService;
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;

        $this->middleware('permission:client-list|client-create|client-edit|client-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:client-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:client-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:client-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $eloquent = $this->clientService->getClientEloquent();
            return DataTables::of($eloquent)
                ->addIndexColumn()
                ->addColumn('name', fn($row) => $row->name)
                ->addColumn('slug', fn($row) => $row->slug)   
                ->addColumn('status', function ($row) {
                    return '<span class="badge ' . ($row->status ? 'bg-success' : 'bg-warning') . '">' 
                        . ($row->status ? 'Publish' : 'Draft') . '</span>';
                })
                ->addColumn('created_at', fn($row) => $row->created_at->diffForHumans())
                ->addColumn('created_by', fn($row) => optional($row->createdBy)->name ?? 'N/A')
                ->addColumn('default_image', function ($row) {
                    $image = '<img src="' . Storage::disk('public')->url($row->default_image?->image_url ?? '') . '" alt="Default" class="img-fluid img-thumbnail rounded" width="50px">';
                    return $image;
                })
                ->addColumn('action', function ($row) {
                    if ($row->status == PostStatusEnum::Draft) {
                        $status = '<i class="fas fa-check"></i>';
                        $button_color = 'btn-success';
                        $button_tooltip = 'Publish';
                        $confirm = '';
                    } else {
                        $status = '<i class="fas fa-ban"></i>';
                        $button_color = 'btn-danger';
                        $button_tooltip = 'Draft';
                        $confirm = 'return confirmInactive(this)';
                    }
                    $btn = '<div class="row m-sm-n1">';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" class="button-size btn btn-sm ' . $button_color . '" href="' . url('admin/clients/' . $row->id . '/change_status') . '"
                        onclick="' . $confirm . '" title="' . $button_tooltip . '">
                       ' . $status . '
                       </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="View" class="button-size btn btn-sm btn-success" href="' . url('admin/clients/' . $row->id . '/') . '"
                       style="color:#FFF">
                      <i class="fas fa-eye"></i>
                      </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><a rel="tooltip" title="Edit" class="button-size btn btn-sm btn-success" href="' . url('admin/clients/' . $row->id . '/edit') . '">
                      <i class="fas fa-edit"></i>
                      </a></div>';
                    $btn = $btn . '<div class="my-1 button-box text-center"><form action="' . route('clients.destroy', $row->id) . '" method="POST" id="del-role-' . $row->id . '" class="d-inline">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="button-size btn btn-sm btn-danger destroy_btn" data-original-title="" data-origin="del-role-' . $row->id . '" title="Delete">
                        <i class="fas fa-trash"></i>
                        </button>                                                    
                        </form></div>';
                    $btn = $btn . '</div>';
                    return $btn;
                })
                ->rawColumns(['name', 'status', 'created_at', 'created_by', 'default_image', 'action'])
                ->make(true);
            }
        return view('backend.client.index');
    }

    public function create()
    {
        $url = route('clients.store');
        return view('backend.client.create', compact('url'));
    }
    public function store(CreateClientRequest $request)
    {
        $this->clientService->create($request->all());
        return redirect('admin/clients')->with('status', 'Client has been added successfully.');
    }

    public function show(Client $client)
    {
        return view('backend.client.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $url = route('clients.update', $client->id);
        return view('backend.client.edit', compact('client', 'url'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->clientService->update($client, $request->all());
        return redirect('admin/clients')->with('status', 'Client has been updated successfully.');
    }

    public function destroy(Client $client)
    {
        $this->clientService->destroy($client);
        return redirect()->route('clients.index')->with('status', 'Client has been deleted successfully.');
    }

    public function changeStatus(Client $client)
    {
        $this->clientService->changeStatus($client);
        return redirect('admin/clients')->with('status', 'Client status has been changed successfully.');
    }
}
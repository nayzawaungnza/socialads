<?php

namespace App\Http\Controllers\Backend;

use DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Faq\StoreFaqRequest;
use App\Http\Requests\Faq\UpdateFaqRequest;
use App\Services\FaqService;
use App\Services\ServiceService;
use App\Models\Faq;

class FaqController extends Controller
{
    protected $faqService;
    protected $serviceService;
    public function __construct(FaqService $faqService, ServiceService $serviceService)
    {
        $this->faqService = $faqService;
        $this->serviceService = $serviceService;

        // $this->middleware('permission:faq-list|faq-create|faq-edit|faq-delete', ['only' => ['index', 'show']]);
        // $this->middleware('permission:faq-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:faq-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:faq-delete', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $eloquent = $this->faqService->getFaqEloquent();
            return DataTables::of($eloquent)
                ->addIndexColumn()
                ->addColumn('content', function ($row) {
                    return '<h5>' . $row->question . '</h5><p>' . $row->answer . '</p>';
                })
                ->addColumn('service', function ($row) {
                    // Option 1: First service name
                    return $row->services->first()->name ?? 'N/A';
                    // Option 2: All service names joined
                    // return $row->services->pluck('name')->implode(', ') ?: 'N/A';
                })
                ->addColumn('status', function ($row) {
                    return '<span class="badge ' . ($row->status ? 'bg-success' : 'bg-warning') . '">' 
                        . ($row->status ? 'Publish' : 'Draft') . '</span>';
                })
                ->addColumn('created_at', fn($row) => $row->created_at->diffForHumans())
                ->addColumn('created_by', fn($row) => optional($row->createdBy)->name ?? 'N/A')
                ->addColumn('action', function ($row) {
                    $btn = '<div class="row m-sm-n1">';
                    $btn .= '<div class="my-1 button-box text-center"><a rel="tooltip" title="View" class="button-size btn btn-sm btn-success" href="' . route('faqs.show', $row->id) . '" style="color:#FFF"><i class="fas fa-eye"></i></a></div>';
                    $btn .= '<div class="my-1 button-box text-center"><a rel="tooltip" title="Edit" class="button-size btn btn-sm btn-success" href="' . route('faqs.edit', $row->id) . '"><i class="fas fa-edit"></i></a></div>';
                    $btn .= '<div class="my-1 button-box text-center"><form action="' . route('faqs.destroy', $row->id) . '" method="POST" id="del-faq-' . $row->id . '" class="d-inline">' .
                            csrf_field() . method_field('DELETE') .
                            '<button type="button" class="button-size btn btn-sm btn-danger destroy_btn" data-origin="del-faq-' . $row->id . '" title="Delete" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></button>' .
                            '</form></div>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['content','status', 'action'])
                ->make(true);
            }
        return view('backend.faq.index');
    }

    public function create()
    {
        $services = $this->serviceService->getServices(1);
        //dd($services);
        $url = route('faqs.store');
        return view('backend.faq.create', compact('url', 'services'));
    }
    public function store(StoreFaqRequest $request)
    {
        $this->faqService->create($request->validated());
        return redirect('admin/faqs')->with('status', 'Faq has been added successfully.');
    }

    public function show(Faq $faq)
    {
        return view('backend.faq.show', compact('faq'));
    }

    public function edit(Faq $faq)
    {
         $services = $this->serviceService->getServices(1);
        $url = route('faqs.update', $faq->id);
        return view('backend.faq.edit', compact('faq', 'url','services'));
    }

    public function update(UpdateFaqRequest $request, Faq $faq)
    {
        $this->faqService->update($faq, $request->validated());
        return redirect('admin/faqs')->with('status', 'Faq has been updated successfully.');
    }

    public function destroy(Faq $faq)
    {
        $this->faqService->destroy($faq);
        return redirect()->route('faqs.index')->with('status', 'Faq has been deleted successfully.');
    }
}

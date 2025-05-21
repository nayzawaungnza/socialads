<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use DataTables;

class ActivityLogController extends Controller
{
    /**
     * @var ActivityLogService
     */
    protected $activityLogService;

    /**
     * ActivityLogController constructor.
     *
     */
    public function __construct(ActivityLogService $activityLogService)
    {
        $this->middleware('permission:activity-list', ['only' => ['index']]);
        $this->activityLogService = $activityLogService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $activity_logs = $this->activityLogService->getActivityLogs($request);
            if ($request->input('order.0.column') === null) {
                $activity_logs->orderBy('created_at', 'desc');
            }
            return DataTables::eloquent($activity_logs)
                ->addIndexColumn()
                ->editColumn('causer_type', function ($activity_log) {
                    return getModelTypeForActivity($activity_log->causer_type);
                })
                ->addColumn('causer_name', function ($activity_log) {
                    return $activity_log->causer?->name;
                })
                ->editColumn('subject_type', function ($activity_log) {
                    return getModelTypeForActivity($activity_log->subject_type);
                })
                ->editColumn('created_at', function ($activity_log) {
                    return $activity_log->created_at?->format(config('constants.DATE_FORMAT.DATAIL_DATE_FORMAT'));
                })
                ->filterColumn('causer_name', function ($query, $keyword) {
                    $query->whereHas('causer', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(activity_log.created_at,'%Y-%m-%d %h:%i %p') like ?", ["%$keyword%"]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('backend.activity_logs.index');
    }
}
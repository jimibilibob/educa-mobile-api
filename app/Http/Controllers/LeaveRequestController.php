<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeaveRequestRequest;
use App\Http\Resources\LeaveRequestResource;
use App\Jobs\RemoveNotificationsJob;
use App\Jobs\SendNotificationsJob;
use App\Models\LeaveRequest;
use App\Models\LeaveRequestTeacher;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaveRequests = LeaveRequest::all();
        return LeaveRequestResource::collection($leaveRequests);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeaveRequestRequest $request)
    {
        $validateData = $request->validated();
        $data = $validateData['data'];
        $teachersId = $data['teachersId'];
        unset($data['teachersId']);
        unset($data['imei']);
        $leaveRequest = LeaveRequest::create($data);

        foreach($teachersId as $teacherId) {
            LeaveRequestTeacher::create([
                'leave_request_id' => $leaveRequest->id,
                'idteacher' => $teacherId,
            ]);
        }

        SendNotificationsJob::dispatch($teachersId, $leaveRequest->id, $request->bearerToken());

        return LeaveRequestResource::make($leaveRequest);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $leaveRequest = LeaveRequest::where('id', $id)
            ->firstOrFail();

        return LeaveRequestResource::make($leaveRequest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        $notificationIds = LeaveRequestTeacher::where('leave_request_id', $leaveRequest->id)->pluck('idnotificacion')->unique()->all();

        $notificationIds[] = ''.$leaveRequest->notificationId;

        RemoveNotificationsJob::dispatch($notificationIds, $request->bearerToken());
        $leaveRequest->leaveRequestTeachers()->delete();
        $leaveRequest->delete();

        return response()->noContent();
    }
}

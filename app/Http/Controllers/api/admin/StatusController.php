<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Status\StoreRequest;
use App\Http\Requests\Status\UpdateRequest;
use App\Http\Resources\StatusResource;
use App\Models\Status;
use App\Service\StatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StatusController extends Controller
{
    public function __construct(protected StatusService $statusService) {}

    public function index(): JsonResponse
    {
        $Statuses = $this->statusService->getStatuses();
        return response()->json([
            'message' => 'Status retrieved successfully',
            'Statuses' => StatusResource::collection($Statuses),
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
          Gate::authorize('create', Status::class);
        $status = $this->statusService->createStatus($request->validate());
        return response()->json([
            'message' => 'Status created successfully',
            'status' => new StatusResource($status),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status): JsonResponse
    {
          Gate::authorize('show', $status);
        $status = $this->statusService->showStatus($status);
        return response()->json([
            'message' => 'Status found successfully',
            'status' => new StatusResource($status),
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Status $status): JsonResponse
    {
          Gate::authorize('update', $status);
        $status = $this->statusService->updateStatus($status, $request->validate());
        return response()->json([
            'message' => 'Status Updated successfully',
            'status' => new StatusResource($status),
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status): JsonResponse
    {
          Gate::authorize('delete', $status);
        $this->statusService->deleteStatus($status);
        return response()->json([
            'message' => 'Status deleted successfully',
        ], Response::HTTP_NO_CONTENT);
    }
}

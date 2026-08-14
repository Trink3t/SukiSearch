<?php

namespace App\Http\Controllers\StoreOwnerEnrollment;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreOwnerEnrollment\StoreOwnerEnrollmentBaseResource;
use App\Http\Resources\StoreOwnerEnrollment\StoreOwnerEnrollmentResource;
use App\Models\StoreOwnerEnrollment;
use App\Queries\StoreOwnerEnrollment\StoreOwnerEnrollmentQuery;
use App\Services\StoreOwnerEnrollmentService;
use Illuminate\Http\Request;

class StoreOwnerEnrollmentController extends Controller
{
    public function __construct(
        private StoreOwnerEnrollmentQuery $query,
        private StoreOwnerEnrollmentService $storeOwnerEnrollmentService
    ) {}

    /**
     * Display a listing of enrollments.
     */
    public function index(Request $request)
    {
        $perPage = min(
            (int) $request->input('per_page', 15),
            100
        );

        $enrollments = $this->query
            ->paginate($perPage)
            ->appends($request->query());

        return StoreOwnerEnrollmentBaseResource::collection($enrollments)->additional([
            'message' => 'Store owner enrollments retrieved successfully.',
        ]);
    }

    /**
     * Store a newly created store owner enrollment.
     */
    public function store(Request $request)
    {
        $this->authorize('create', StoreOwnerEnrollment::class);

        $enrollment = $this->storeOwnerEnrollmentService->enrollAsStoreOwner($user ?? $request->user());

        return $this->successResponse(
            data: StoreOwnerEnrollmentResource::make($enrollment),
            message: 'Store owner enrollment created successfully.'
        );
    }

    /**
     * Display the specified enrollment.
     */
    public function show(StoreOwnerEnrollment $storeOwnerEnrollment)
    {
        return $this->successResponse(
            data: StoreOwnerEnrollmentResource::make($storeOwnerEnrollment->load('user'))
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StoreOwnerEnrollment $storeOwnerEnrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreOwnerEnrollment $storeOwnerEnrollment)
    {
        //
    }
}

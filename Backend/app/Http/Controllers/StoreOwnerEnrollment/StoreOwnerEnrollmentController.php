<?php

namespace App\Http\Controllers\StoreOwnerEnrollment;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOwnerEnrollment\StoreOwnerEnrollmentIndexRequest;
use App\Http\Resources\StoreOwnerEnrollment\StoreOwnerEnrollmentBaseResource;
use App\Http\Resources\StoreOwnerEnrollment\StoreOwnerEnrollmentResource;
use App\Models\StoreOwnerEnrollment;
use App\Queries\StoreOwnerEnrollment\StoreOwnerEnrollmentQuery;
use App\Services\StoreOwnerEnrollmentService;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

#[Group('StoreOwnerEnrollment')]
class StoreOwnerEnrollmentController extends Controller
{
    public function __construct(
        private StoreOwnerEnrollmentQuery $query,
        private StoreOwnerEnrollmentService $storeOwnerEnrollmentService
    ) {}

    /**
     * List store-owner enrollment requests with filtering, sorting, and pagination.
     */
    #[QueryParameter('filter[id]', type: 'integer')]
    #[QueryParameter('filter[status]', type: 'string')]
    #[QueryParameter('page', type: 'integer', example: 1)]
    #[QueryParameter('per_page', type: 'integer', example: 15)]
    #[QueryParameter('sort', type: 'string', example: '-created_at')]
    public function index(StoreOwnerEnrollmentIndexRequest $request)
    {
        $perPage = min(
            $request->integer('per_page', 15),
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
     * Submit the authenticated user's request to become a SukiSearch store owner.
     */
    public function store(Request $request)
    {
        $this->authorize('create', StoreOwnerEnrollment::class);

        $enrollment = $this->storeOwnerEnrollmentService->enrollAsStoreOwner($user ?? $request->user());

        return $this->successResponse(
            data: StoreOwnerEnrollmentResource::make($enrollment),
            message: 'Store owner enrollment created successfully.',
            status: Response::HTTP_CREATED
        );
    }

    /**
     * Retrieve a store-owner enrollment request and its applicant.
     */
    public function show(StoreOwnerEnrollment $storeOwnerEnrollment)
    {
        return $this->successResponse(
            data: StoreOwnerEnrollmentResource::make($storeOwnerEnrollment->load('user'))
        );
    }

    public function update(Request $request, StoreOwnerEnrollment $storeOwnerEnrollment)
    {
        //
    }

    public function destroy(StoreOwnerEnrollment $storeOwnerEnrollment)
    {
        //
    }
}

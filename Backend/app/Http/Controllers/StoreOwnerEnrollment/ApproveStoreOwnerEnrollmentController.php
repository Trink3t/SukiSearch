<?php

namespace App\Http\Controllers\StoreOwnerEnrollment;

use App\Http\Controllers\Controller;
use App\Models\StoreOwnerEnrollment;
use App\Services\StoreOwnerEnrollmentService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;

#[Group('StoreOwnerEnrollment')]
class ApproveStoreOwnerEnrollmentController extends Controller
{
    public function __construct(
        private readonly StoreOwnerEnrollmentService $storeOwnerEnrollmentService
    ) {}

    /**
     * Approve store owner's enrollment.
     */
    public function __invoke(Request $request, StoreOwnerEnrollment $storeOwnerEnrollment)
    {
        $this->authorize('updateStatus', $storeOwnerEnrollment);

        $this->storeOwnerEnrollmentService->approveEnrollment(
            enrollment: $storeOwnerEnrollment,
            admin: $request->user()
        );

        return $this->successResponse(
            message: 'Store owner enrollment approved successfully.'
        );
    }
}

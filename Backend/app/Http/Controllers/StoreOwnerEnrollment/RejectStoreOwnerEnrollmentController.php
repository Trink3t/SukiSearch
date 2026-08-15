<?php

namespace App\Http\Controllers\StoreOwnerEnrollment;

use App\Http\Controllers\Controller;
use App\Models\StoreOwnerEnrollment;
use App\Services\StoreOwnerEnrollmentService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;

#[Group('StoreOwnerEnrollment')]
class RejectStoreOwnerEnrollmentController extends Controller
{
    public function __construct(
        private readonly StoreOwnerEnrollmentService $storeOwnerEnrollmentService
    ) {}

    /**
     * Reject a pending store-owner enrollment with a reason.
     */
    public function __invoke(Request $request, StoreOwnerEnrollment $storeOwnerEnrollment)
    {
        $this->authorize('updateStatus', $storeOwnerEnrollment);

        $validated = $request->validate([
            'reason' => ['required', 'string', 'min:10', 'max:500'],
        ]);

        $this->storeOwnerEnrollmentService->rejectEnrollment(
            enrollment: $storeOwnerEnrollment,
            admin: $request->user(),
            reason: $validated['reason']
        );

        return $this->successResponse(
            message: 'Store owner enrollment rejected successfully.'
        );
    }
}

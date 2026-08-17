<?php

namespace App\Http\Controllers\Store\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Services\StoreService;
use Dedoc\Scramble\Attributes\Group;

#[Group('Store')]
class SetStoreStatusController extends Controller
{
    public function __construct(
        public readonly StoreService $storeService
    ) {}

    /**
     * (Admin) Suspend the specified store.
     */
    public function suspend(Store $store)
    {
        $this->authorize('suspend', $store);

        $store = $this->storeService->suspend($store);

        return $this->successResponse(
            data: $store,
            message: 'Store suspended successfully.',
        );
    }

    /**
     * (Admin) Activate the specified store.
     */
    public function activate(Store $store)
    {
        $this->authorize('activate', $store);

        $store = $this->storeService->activate($store);

        return $this->successResponse(
            data: $store,
            message: 'Store activated successfully.',
        );
    }

    /**
     * (Admin) Close the specified store.
     */
    public function close(Store $store)
    {
        $this->authorize('close', $store);

        $store = $this->storeService->close($store);

        return $this->successResponse(
            data: $store,
            message: 'Store closed successfully.',
        );
    }
}

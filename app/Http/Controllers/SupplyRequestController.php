<?php

namespace App\Http\Controllers;

use App\Models\SupplyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SupplyRequestController extends Controller
{
    /**
     * Display the specified supply request receipt.
     *
     * @param SupplyRequest $supplyRequest
     * @return View
     */
    public function show(SupplyRequest $supplyRequest): View
    {
        // Authorize to ensure the user can only see their own requisitions.
        // This assumes a 'view' method exists in a SupplyRequestPolicy.
        // If not, a simple check can be done here:
        if ($supplyRequest->user_id !== Auth::id()) {
            abort(403);
        }

        return view('supply.receipt', [
            'supplyRequest' => $supplyRequest
        ]);
    }
}

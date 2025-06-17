<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    // Get all merchants with note count
    public function index()
    {
        $merchants = Merchant::withCount('notes')->get();

        return response()->json([
            'merchants' => $merchants
        ]);
    }

    // Show a specific merchant with its notes
    public function show($id)
    {
        $merchant = Merchant::with('notes')->findOrFail($id);

        return response()->json([
            'merchant' => $merchant
        ]);
    }

    // Get only notes of a specific merchant
    public function notes($id)
    {
        $merchant = Merchant::findOrFail($id);
        $notes = $merchant->notes()->orderBy('created_at', 'desc')->get();

        return response()->json([
            'merchant' => $merchant,
            'notes' => $notes
        ]);
    }
}

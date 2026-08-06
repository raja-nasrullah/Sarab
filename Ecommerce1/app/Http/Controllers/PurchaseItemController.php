<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use Illuminate\Http\Request;

class PurchaseItemController extends Controller
{
    public function index(Request $request)
{
    // Start the query
    $query = PurchaseItem::with('purchase', 'inventory');

    // If a purchase_id is passed in the URL, filter the results
    if ($request->has('purchase_id')) {
        $query->where('purchase_id', $request->purchase_id);
    }

    // Get the results
    $purchaseItems = $query->get();
    return response()->json($purchaseItems);
}

    public function store(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'inventory_id' => 'required|exists:inventory,id',
            'quantity' => 'required|numeric|min:0.01',
            'price' => 'required|numeric|min:0',
        ]);

        $purchaseItem = PurchaseItem::create($request->all());
        return response()->json($purchaseItem, 201);
    }

    public function show($id)
    {
        $purchaseItem = PurchaseItem::with('purchase', 'inventory')->find($id);
        if (!$purchaseItem) {
            return response()->json(['message' => 'Purchase item not found'], 404);
        }
        return response()->json($purchaseItem);
    }

    public function update(Request $request, $id)
    {
        $purchaseItem = PurchaseItem::find($id);
        if (!$purchaseItem) {
            return response()->json(['message' => 'Purchase item not found'], 404);
        }

        $request->validate([
            'quantity' => 'sometimes|numeric|min:0.01',
            'price' => 'sometimes|numeric|min:0',
        ]);

        $purchaseItem->update($request->all());
        return response()->json($purchaseItem);
    }

    public function destroy($id)
    {
        $purchaseItem = PurchaseItem::find($id);
        if (!$purchaseItem) {
            return response()->json(['message' => 'Purchase item not found'], 404);
        }

        $purchaseItem->delete();
        return response()->json(['message' => 'Purchase item deleted successfully']);
    }
}
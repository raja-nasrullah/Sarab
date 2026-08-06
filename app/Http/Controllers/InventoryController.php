<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = Inventory::with('purchaseItems')->get();
        return response()->json($inventory);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
        ]);

        $inventory = Inventory::create($request->all());
        return response()->json($inventory, 201);
    }

    public function show($id)
    {
        $inventory = Inventory::with('purchaseItems')->find($id);
        if (!$inventory) {
            return response()->json(['message' => 'Inventory item not found'], 404);
        }
        return response()->json($inventory);
    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::find($id);
        if (!$inventory) {
            return response()->json(['message' => 'Inventory item not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|numeric|min:0',
            'unit' => 'sometimes|string|max:50',
        ]);

        $inventory->update($request->all());
        return response()->json($inventory);
    }

    public function destroy($id)
    {
        $inventory = Inventory::find($id);
        if (!$inventory) {
            return response()->json(['message' => 'Inventory item not found'], 404);
        }

        $inventory->delete();
        return response()->json(['message' => 'Inventory item deleted successfully']);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    // 👇 NEW METHOD FOR ADMIN VIEW
    public function adminIndex()
    {
        $purchases = Purchase::with('purchaseItems')->orderBy('purchase_date', 'desc')->get();
        return view('admin.pages.purchases.purchase', compact('purchases'));
    }

    public function index()
    {
        $purchases = Purchase::with('purchaseItems.inventory')->get();
        return response()->json($purchases);
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.inventory_id' => 'required|exists:inventory,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $purchase = Purchase::create($request->except('items'));

            foreach ($request->items as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'inventory_id' => $item['inventory_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update inventory quantity
                $inventory = Inventory::find($item['inventory_id']);
                $inventory->quantity += $item['quantity'];
                $inventory->save();
            }

            DB::commit();
            return response()->json($purchase->load('purchaseItems'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create purchase: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $purchase = Purchase::with('purchaseItems.inventory')->find($id);
        if (!$purchase) {
            return response()->json(['message' => 'Purchase not found'], 404);
        }
        return response()->json($purchase);
    }

    public function update(Request $request, $id)
    {
        $purchase = Purchase::find($id);
        if (!$purchase) {
            return response()->json(['message' => 'Purchase not found'], 404);
        }

        $request->validate([
            'purchase_date' => 'sometimes|date',
            'total_amount' => 'sometimes|numeric|min:0',
        ]);

        $purchase->update($request->all());
        return response()->json($purchase);
    }

    public function destroy($id)
    {
        $purchase = Purchase::find($id);
        if (!$purchase) {
            return response()->json(['message' => 'Purchase not found'], 404);
        }

        $purchase->delete();
        return response()->json(['message' => 'Purchase deleted successfully']);
    }
        // Show the add purchase form
    public function addpurchase()
    {
        $inventoryItems = \App\Models\Inventory::all();
        return view('admin.pages.purchases.addpurchase', compact('inventoryItems'));
    }

    // Store the purchase from the admin panel
    public function storeAddpurchase(Request $request)
    {
        $request->validate([
            'purchase_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.inventory_id' => 'required|exists:inventory,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $purchase = Purchase::create([
                'purchase_date' => $request->purchase_date,
                'total_amount' => $request->total_amount,
            ]);

            foreach ($request->items as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'inventory_id' => $item['inventory_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update inventory quantity
                $inventory = Inventory::find($item['inventory_id']);
                $inventory->quantity += $item['quantity'];
                $inventory->save();
            }

            DB::commit();
            return redirect()->route('admin.purchases')->with('success', 'Purchase added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create purchase: ' . $e->getMessage()]);
        }
    }
}
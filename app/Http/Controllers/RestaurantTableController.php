<?php

namespace App\Http\Controllers;

use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class RestaurantTableController extends Controller
{
    public function index()
    {
        $tables = RestaurantTable::with('orders', 'reservations')->get();
        return response()->json($tables);
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|string|unique:restaurant_tables',
            'capacity' => 'required|integer|min:1',
            'status' => 'sometimes|in:available,occupied,reserved',
        ]);

        $table = RestaurantTable::create($request->all());
        return response()->json($table, 201);
    }

    public function show($id)
    {
        $table = RestaurantTable::with('orders', 'reservations')->find($id);
        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }
        return response()->json($table);
    }

    public function update(Request $request, $id)
    {
        $table = RestaurantTable::find($id);
        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        $request->validate([
            'table_number' => 'sometimes|string|unique:restaurant_tables,table_number,' . $id,
            'capacity' => 'sometimes|integer|min:1',
            'status' => 'sometimes|in:available,occupied,reserved',
        ]);

        $table->update($request->all());
        return response()->json($table);
    }

    public function destroy($id)
    {
        $table = RestaurantTable::find($id);
        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        $table->delete();
        return response()->json(['message' => 'Table deleted successfully']);
    }
}
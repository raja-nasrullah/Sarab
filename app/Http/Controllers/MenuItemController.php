<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    // 👇 THIS IS THE NEW METHOD FOR THE ADMIN PAGE
    public function adminIndex()
    {
        $menuItems = MenuItem::with('category')->get();

        // CHANGE THIS LINE: Add 'menu/' before the file name
        return view('admin.pages.menu.menu', compact('menuItems'));
    }

    public function index()
    {
        $menuItems = MenuItem::with('category')->get();
        return response()->json($menuItems);
    }

    // Show the add menu form
    public function addmenu()
    {
        $categories = \App\Models\Category::all();
        return view('admin.pages.menu.addmenu', compact('categories'));
    }

    // ✅ UPDATED: Save the new item from the admin panel (WITH IMAGE SUPPORT)
    public function storeAddmenu(Request $request)
{
    $request->validate([
        'category_id' => 'nullable|exists:categories,id',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'status' => 'sometimes|in:Available,unavailable',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('menu_images', 'public');
        $data['image'] = $path; // Stores 'menu_images/filename.jpg'
    }

    \App\Models\MenuItem::create($data);

    return redirect()->route('admin.menu')->with('success', 'Menu item added successfully!');
}

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'sometimes|in:available,unavailable',
        ]);

        $menuItem = MenuItem::create($request->all());
        return response()->json($menuItem, 201);
    }

 public function show($id)
{
    $menuItem = MenuItem::with('category', 'orderItems')->find($id);
    if (!$menuItem) {
        return response()->json(['error' => 'Item not found'], 404);
    }
    return response()->json($menuItem);
}

    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::find($id);
        if (!$menuItem) {
            return response()->json(['message' => 'Menu item not found'], 404);
        }

        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:available,unavailable',
        ]);

        $menuItem->update($request->all());
        return response()->json($menuItem);
    }

    public function destroy($id)
    {
        $menuItem = MenuItem::find($id);
        if (!$menuItem) {
            return response()->json(['message' => 'Menu item not found'], 404);
        }

        $menuItem->delete();
        return response()->json(['message' => 'Menu item deleted successfully']);
    }

    // Show the edit form
    public function editmenu($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('admin.pages.menu.editmenu', compact('menuItem', 'categories'));
    }

    // ✅ UPDATED: Update the item from the admin panel (WITH IMAGE SUPPORT)
    public function updateEditmenu(Request $request, $id)
{
    $menuItem = MenuItem::findOrFail($id);

    $request->validate([
        'category_id' => 'nullable|exists:categories,id',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'status' => 'sometimes|in:Available,unavailable',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
    ]);

    $data = $request->all();

    // ✅ THIS IS THE CRITICAL PART!
    if ($request->hasFile('image')) {
        // 1. Store the file in storage/app/public/menu_images
        $path = $request->file('image')->store('menu_images', 'public');
        
        // 2. Save just the path (menu_images/filename.jpg) to the database
        $data['image'] = $path; 
    }

    $menuItem->update($data);

    return redirect()->route('admin.menu')->with('success', 'Menu item updated successfully!');
}

    public function destroyMenu($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->delete();

        // This redirects back to the SAME menu page after deleting
        return redirect()->route('admin.menu')->with('success', 'Menu item deleted successfully!');
    }

        // 👇 ADD THIS METHOD FOR THE PUBLIC WEBSITE MENU PAGE
    public function websiteIndex()
    {
        // 1. Fetch all categories
        $categories = \App\Models\Category::all();

        // 2. Fetch all available menu items with their categories
        $menuItems = MenuItem::with('category')
                    ->where('status', 'Available')
                    ->get();

        // 3. Return the public website view
        return view('website.pages.menu', compact('categories', 'menuItems'));
    }
    
}
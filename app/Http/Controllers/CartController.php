<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // 1. Add items to Session Cart
    public function addToCart(Request $request)
    {
        $itemId = $request->input('item_id');
        $quantity = $request->input('quantity', 1);

        $menuItem = MenuItem::find($itemId);
        if (!$menuItem) {
            return response()->json(['success' => false, 'message' => 'Item not found!']);
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity'] += $quantity;
        } else {
            $cart[$itemId] = [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'price' => $menuItem->price,
                'image' => $menuItem->image,
                'quantity' => $quantity,
            ];
        }

        Session::put('cart', $cart);
        $totalItems = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => "{$menuItem->name} added to cart!",
            'cart_count' => $totalItems
        ]);
    }

    // ✅ 2. Show the Cart Page (Checkout Page)
    public function showCart()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Pass cart items and total to the new view
        return view('website.pages.cart', compact('cart', 'total'));
    }
        // ✅ Add this method to get the count for the badge
    public function getCartCount()
    {
        $cart = Session::get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));
        return response()->json(['count' => $count]);
    }
        // ✅ NEW METHOD: Remove an item from the cart
    public function removeFromCart($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        // Calculate the new total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'new_total' => number_format($total, 2),
            'cart_count' => count($cart)
        ]);
    }
}
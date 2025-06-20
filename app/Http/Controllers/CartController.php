<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $menuId = $request->menu_id;
        $quantityChange = $request->quantity;

        $cart = session()->get('cart', []);

        if (isset($cart[$menuId])) {
            $cart[$menuId]['quantity'] += $quantityChange;
            if ($cart[$menuId]['quantity'] <= 0) {
                unset($cart[$menuId]);
            }
        } else if ($quantityChange > 0) {
            $menu = Menu::find($menuId);
            if ($menu) {
                $cart[$menuId] = [
                    'name' => $menu->name,
                    'price' => $menu->price,
                    'quantity' => $quantityChange,
                ];
            }
        }

        session()->put('cart', $cart);

        return response()->json(['cart' => $cart]);
    }


    public function remove(Request $request)
    {
        $menuId = $request->input('menu_id');

        $cart = session()->get('cart', []);

        if (isset($cart[$menuId])) {
            if ($cart[$menuId]['quantity'] > 1) {
                $cart[$menuId]['quantity']--;
            } else {
                unset($cart[$menuId]);
            }

            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk diupdate!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Keranjang dikosongkan!');
    }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }
}

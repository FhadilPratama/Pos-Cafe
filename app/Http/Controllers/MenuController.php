<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $min_price = $request->query('min_price');
        $max_price = $request->query('max_price');
        $search = $request->query('search');

        $query = Menu::query();

        if ($category && in_array($category, ['makanan', 'minuman'])) {
            $query->where('category', $category);
        }

        if ($min_price && is_numeric($min_price)) {
            $query->where('price', '>=', $min_price);
        }

        if ($max_price && is_numeric($max_price)) {
            $query->where('price', '<=', $max_price);
        }

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $menus = $query->get();

        return view('menus.index', compact('menus', 'category', 'min_price', 'max_price', 'search'));
    }

    public function create()
    {
        return view('menus.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category' => 'required|in:makanan,minuman',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/menus'), $imageName);
            $data['image'] = 'images/menus/' . $imageName;
        }

        Menu::create($data);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category' => 'required|in:makanan,minuman',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/menus'), $imageName);
            $data['image'] = 'images/menus/' . $imageName;
        }

        $menu->update($data);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diupdate.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus.');
    }
}

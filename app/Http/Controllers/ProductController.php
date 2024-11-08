<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $productQuery = Product::query();

        if ($productQuery->count() > 0) {
            if (request()->has('search')) {
                $search = $request->get('search');
                $productQuery->where('product_id', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            }
        }

        $sortItems = $request->get("sort", 'name');
        $sortDirection = $request->get("direction", 'asc');

        if (in_array($sortItems, ['name', 'price'])) {
            $productQuery->orderBy($sortItems, $sortDirection);
        }

        $products = $productQuery->paginate(10);

        return view("products.index", compact("products"));
    }

    public function create()
    {
        return view("products.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|unique:products',
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            return view("products.show", compact("product"));
        } else {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }
    }

    public function edit(string $id)
    {
        $product = Product::find($id);

        if ($product) {
            return view("products.edit", compact("product"));
        } else {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'product_id' => 'required|unique:products,product_id,' . $id,
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::find($id);

        if ($product) {
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $validated['image'] = $path;
            }

            $product->update($validated);

            return redirect()->route('products.index')->with('success', 'Product updated successfully');
        } else {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        } else {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }
    }
}

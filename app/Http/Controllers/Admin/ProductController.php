<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function view($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('products.view', compact('product'));
    }

    public function index(Request $request)
    {
        $categories = Category::parent(false)->ordered()->active()->with('children')->get();

        $products = Product::ordered()
            ->when($request->input('categoryId'), function ($query, $categoryId) {
                return $query->whereHas('category', function ($q) use ($categoryId) {
                    $q->whereKey($categoryId);
                });
            })
            ->when($request->input('search'), function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('tags', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            })->when($request->input('price'), function ($query, $price) {
                return $query->where('price', '>=', $price);
            })->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })->when($request->input('description'), function ($query, $description) {
                return $query->where('description', 'like', '%' . $description . '%');
            })->when($request->input('tags'), function ($query, $tags) {
                return $query->where('tags', 'like', '%' . $tags . '%');
            })->when($request->input('code'), function ($query, $code) {
                return $query->where('code', $code);
            })
            ->paginate(9);
        sleep(2);

        if ($request->ajax()) {
            return view('partials.product_list', compact('products')); // Return product list only
        }

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable',
            'image' => 'nullable|image'
        ]);

        // Store product
        $product = new Product($request->all());

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('product-images', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable',
            'image' => 'nullable|image'
        ]);

        $product->fill($request->all());

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('product-images', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

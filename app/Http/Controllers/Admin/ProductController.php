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
            })
            ->paginate(9);

        sleep(2);

        if ($request->ajax()) {
            return view('partials.product_list', compact('products'));
        }

        return view('products.index', compact('products', 'categories'));
    }

    public function list(Request $request)
    {
        $categories = Category::ordered()->active()->get();

        $products = Product::ordered()
            // Filter by category ID
            ->when($request->input('categoryId'), function ($query, $categoryId) {
                return $query->whereHas('category', function ($q) use ($categoryId) {
                    $q->whereKey($categoryId);
                });
            })
            // Filter by search term (name, description, tags, or code)
            ->when($request->input('search'), function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('tags', 'like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%');
                });
            })
            // Filter by price
            ->when($request->input('price'), function ($query, $price) {
                return $query->where('price', 'like', '%' . $price . '%');
            })
            // Filter by name
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            // Filter by description
            ->when($request->input('description'), function ($query, $description) {
                return $query->where('description', 'like', '%' . $description . '%');
            })
            // Filter by tags
            ->when($request->input('tags'), function ($query, $tags) {
                return $query->where('tags', 'like', '%' . $tags . '%');
            })
            // Filter by code
            ->when($request->input('code'), function ($query, $code) {
                return $query->where('code', $code);
            })
            // Filter by active/inactive status
            ->when($request->input('active') !== null, function ($query) use ($request) {
                return $query->where('active', $request->input('active'));
            })
            ->paginate(9);

        sleep(2);

        if ($request->ajax()) {
            return view('partials.admin_product_list', compact('products'));
        }

        return view('admin.index', compact('products', 'categories'));
    }


    public function create()
    {
        $categories = Category::active()->ordered()->get();
        $mode = 'create';
        return view('products.create', compact('categories', 'mode'));
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

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::active()->ordered()->get();
        $mode = 'update';
        return view('products.edit', compact('product', 'categories', 'mode'));
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

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('products.list')->with('success', 'Product deleted successfully.');
    }
}

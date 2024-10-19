<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
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
            ->when($request->input('categoryId'), function ($query, $categoryId) {
                return $query->whereHas('category', function ($q) use ($categoryId) {
                    $q->whereKey($categoryId);
                });
            })
            ->when($request->input('search'), function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('tags', 'like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%');
                });
            })
            ->when($request->input('price'), function ($query, $price) {
                return $query->where('price', 'like', '%' . $price . '%');
            })
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($request->input('description'), function ($query, $description) {
                return $query->where('description', 'like', '%' . $description . '%');
            })
            ->when($request->input('tags'), function ($query, $tags) {
                return $query->where('tags', 'like', '%' . $tags . '%');
            })
            ->when($request->input('code'), function ($query, $code) {
                return $query->where('code', $code);
            })
            ->when($request->input('active') !== null, function ($query) use ($request) {
                return $query->where('active', $request->input('active'));
            })
            ->paginate(20);

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

    public function store(ProductCreateRequest $request)
    {
        $product = new Product();

        $product->forceFill($request->validated());

        if ($request->hasFile('image')) {
            $product->image = upload_file($request->file('image'));
        }

        $product->save();

        return redirect()->route('products.list')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::active()->ordered()->get();
        $mode = 'update';
        return view('products.edit', compact('product', 'categories', 'mode'));
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->forceFill($request->validated());

        if ($request->hasFile('image')) {
            $product->image = upload_file($request->file('image'));
        }

        $product->save();

        return redirect()->route('products.list')->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('products.list')->with('success', 'Product deleted successfully.');
    }

    // TODO: impelement export 
    public function export(Request $request)
    {
        $categories = Category::ordered()->active()->get();

        $query = Product::ordered()
            ->when($request->input('categoryId'), function ($query, $categoryId) {
                return $query->whereHas('category', function ($q) use ($categoryId) {
                    $q->whereKey($categoryId);
                });
            })
            ->when($request->input('search'), function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('tags', 'like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%');
                });
            })
            ->when($request->input('price'), function ($query, $price) {
                return $query->where('price', 'like', '%' . $price . '%');
            })
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($request->input('description'), function ($query, $description) {
                return $query->where('description', 'like', '%' . $description . '%');
            })
            // Filter by tags
            ->when($request->input('tags'), function ($query, $tags) {
                return $query->where('tags', 'like', '%' . $tags . '%');
            })
            ->when($request->input('code'), function ($query, $code) {
                return $query->where('code', $code);
            })
            ->when($request->input('active') !== null, function ($query) use ($request) {
                return $query->where('active', $request->input('active'));
            });


        // ExportJob::dispatch(
        //     exportable: $exportable ?? new Export(class: new self(), fields: $fields, filters: $filters, textColumns: $textColumns, phoneColumns: $phoneColumns),
        //     topic: $topic,
        //     fileHash: md5(microtime()),
        //     userId: $user->id,
        //     locale: App::getLocale(),
        // );

    }
}

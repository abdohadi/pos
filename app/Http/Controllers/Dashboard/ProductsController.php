<?php

namespace App\Http\Controllers\Dashboard;

use App\Product;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Storage;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_products'])->only('index');
        $this->middleware(['permission:create_products'])->only('create');
        $this->middleware(['permission:update_products'])->only('edit');
        $this->middleware(['permission:delete_products'])->only('destroy');
    }

    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::when($request->search, function($q) use ($request) {
            return $q->whereTranslationLike('name', '%' .$request->search. '%');
        })->when($request->category_id, function($q) use ($request) {
            return $q->where('category_id', $request->category_id);
        })->latest()->paginate(5);

        return view('dashboard.products.index', compact(['products', 'categories']));
    }

    public function create()
    {
        $categories = Category::all();

        return view('dashboard.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'category_id' => 'required|numeric|min:1',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale. '.name' => 'required|unique:product_translations,name'];
            $rules += [$locale. '.description' => 'required'];
        }

        $rules += [
            'purchase_price' => 'required|numeric|min:1',
            'sale_price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
        ];

        $request->validate($rules);

        $attributes = $request->all();

        if ($request->image) {
            Image::make($request->image)
                ->resize(300, null, function($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/product_images/' .$request->image->hashName()));

            $attributes['image'] = $request->image->hashName();
        }

        Product::create($attributes);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.products.index');
    }

    public function show(Product $product)
    {
        return abort(404);
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        
        return view('dashboard.products.edit', compact(['product', 'categories']));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'category_id' => 'required|numeric|min:1',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale. '.name' => ['required', Rule::unique('product_translations', 'name')->ignore($product->id, 'product_id')]];
            $rules += [$locale. '.description' => 'required'];
        }

        $rules += [
            'purchase_price' => 'required|numeric|min:1',
            'sale_price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
        ];

        $request->validate($rules);

        $attributes = $request->except('image');

        if ($request->image) {
            if ($product->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/product_images/' .$product->image);
            }

            Image::make($request->image)
                ->resize(300, null, function($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/product_images/' .$request->image->hashName()));

            $attributes['image'] = $request->image->hashName();
        }

        $product->update($attributes);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.products.index');
    }

    public function destroy(Product $product)
    {
        if ($product->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/product_images/' .$product->image);
        }

        $product->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.products.index');
    }
}

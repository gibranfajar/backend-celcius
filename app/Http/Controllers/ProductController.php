<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Products';
        $data = Product::orderBy('id', 'desc')->get();

        return view('products.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Product';
        $categories = Category::all();
        $colors = Color::all();
        $collections = Collection::all();

        return view('products.create', compact('title', 'categories', 'colors', 'collections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request data from form
        $request->validate([
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size.*' => 'required',
            'stock.*' => 'required',
            'name' => 'required',
            'category' => 'required',
            'color' => 'required',
            'collection' => 'nullable',
            'type' => 'required',
            'weight' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'article' => 'required',
            'plu' => 'required',
            'description' => 'required',
            'sizechart' => 'required',
        ]);

        // Create product to database
        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category,
            'color_id' => $request->color,
            'collection_id' => $request->collection ?: null,
            'type' => $request->type,
            'weight' => $request->weight,
            'price' => $request->price,
            'discount' => $request->discount,
            'article' => $request->article,
            'plu' => $request->plu,
            'description' => $request->description,
            'sizechart' => $request->sizechart,
        ]);

        // Upload images
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        }

        // Upload sizes and stocks
        if ($request->has('size') && $request->has('stock')) {
            foreach ($request->size as $key => $size) {
                Size::create([
                    'size' => $size,
                    'stock' => $request->stock[$key],
                    'product_id' => $product->id
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $title = 'Edit Product';
        $categories = Category::all();
        $colors = Color::all();
        $collections = Collection::all();

        $images = ProductImage::where('product_id', $product->id)->get();
        $sizes = Size::where('product_id', $product->id)->get();

        return view('products.edit', compact('title', 'product', 'categories', 'colors', 'collections', 'images', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validasi request
        $request->validate([
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size.*' => 'required',
            'stock.*' => 'required|integer',
            'name' => 'required',
            'category' => 'required',
            'color' => 'required',
            'collection' => 'nullable',
            'type' => 'required',
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'article' => 'required',
            'plu' => 'required',
            'description' => 'required',
            'sizechart' => 'required',
        ]);

        // Update data produk
        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category,
            'color_id' => $request->color,
            'collection_id' => $request->collection ?: null,
            'type' => $request->type,
            'weight' => $request->weight,
            'price' => $request->price,
            'discount' => $request->discount,
            'article' => $request->article,
            'plu' => $request->plu,
            'description' => $request->description,
            'sizechart' => $request->sizechart
        ]);

        // Upload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            ProductImage::where('product_id', $product->id)->each(function ($image) {
                Storage::disk('public')->delete($image->image);
                $image->delete();
            });

            // Simpan gambar baru
            foreach ($request->file('image') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image' => $path]);
            }
        }

        // Update ukuran dan stok
        if ($request->has('size') && $request->has('stock')) {
            // Hapus ukuran lama
            $sizes = Size::where('product_id', $product->id)->delete();

            // Simpan ukuran dan stok baru
            foreach ($request->size as $key => $size) {
                Size::create([
                    'size' => $size,
                    'stock' => $request->stock[$key],
                    'product_id' => $product->id
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }


    // update status product
    public function status(Request $request, Product $product)
    {
        // Validasi request
        $request->validate([
            'status' => 'required',
        ]);

        if ($product) {
            Product::where('id', $product->id)->update([
                'status' => $request->status
            ]);
            return redirect()->route('products.index')->with('success', 'Product status updated successfully.');
        }

        return redirect()->route('products.index')->with('error', 'Product not found.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

use App\Product;
use App\ProductGallery;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\ProductGalleryRequest;

use Illuminate\Support\Str;

class DashboardProductController extends Controller
{
    public function index()
    {
        $product = Product::with(['galleries', 'category'])
                    ->where('users_id', Auth::user()->id)
                    ->get();

        return view ('pages.dashboard-product', [
            'product' => $product
        ]);
    }

     public function detail(Request $request, $id)
    {
        $product = Product::with(['galleries', 'user', 'category'])
                        ->findOrFail($id);
        $categories = Category::all();

        return view ('pages.dashboard-product-detail', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function uploadGallery(Request $request)
    {
        $data = $request->all();

        $data['photos'] = $request->file('photos')->store('assets/product', 'public');

        ProductGallery::create($data);

        return redirect()->route('dashboard-product-detail', $request->products_id)
                    ->with(['create' => 'Berhasil menambah data Galeri']);
    }

    public function deleteGallery(Request $request, $id)
    {
        $item = ProductGallery::findorFail($id);
        $item->delete();

        return redirect()->route('dashboard-product-detail', $item->products_id)
                    ->with(['delete' => 'Berhasil menghapus data Galeri']);
    }

     public function create()
    {
        $categories = Category::all();
        return view ('pages.dashboard-product-create', [
            'categories' => $categories
        ]);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);

        $product = Product::create($data);
        $gallery = [
            'products_id' => $product->id,
            'photos' => $request->file('photo')->store('assets/product', 'public')
        ];

        ProductGallery::create($gallery);

        return redirect()->route('dashboard-product')
                ->with(['create' => 'Berhasil menambah data Produk']);
    }

    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();

        $item = Product::findOrFail($id);

        $data['slug'] = Str::slug($request->name);

        $item->update($data);

        return redirect()->route('dashboard-product')->with(['update' => 'Data Product berhasil diperbarui']);
        // return redirect()->route('product.index');
    }
}

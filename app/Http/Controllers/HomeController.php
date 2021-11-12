<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Slider;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::take(6)->get();
        $products = Product::with('galleries')->take(8)->get();
        $sliders = Slider::all();

        return view('pages.home',[
            'categories' => $categories,
            'products' => $products,
            'sliders' => $sliders
        ]);
    }
}

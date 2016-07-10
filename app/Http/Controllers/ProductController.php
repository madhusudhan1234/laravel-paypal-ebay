<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests;

class ProductController extends Controller
{
    /**
     * @var Product
     */
    private $products;

    /**
     * ProductController constructor.
     * @param Product $products
     */
    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $products = $this->products->all();
        
        return view('products.index',compact('products'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function order($id)
    {
        $product = $this->products->findOrFail($id);

        return view('products.order',compact('product'));
    }
}

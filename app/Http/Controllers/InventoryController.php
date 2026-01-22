<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource (admin side).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::select('name', 'sku', 'stock')->orderBy('name')->get();
        return view('admin.inventory.index', compact('products'));
    }
}
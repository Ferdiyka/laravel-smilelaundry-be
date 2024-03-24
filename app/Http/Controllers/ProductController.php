<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        //get products with pagination
        $products = DB::table('products')
        ->where(function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%')
                  ->orWhere('price', 'like', '%' . $keyword . '%')
                  ->orWhere('duration', 'like', '%' . $keyword . '%')
                  ->orWhere('description', 'like', '%' . $keyword . '%')
                  ->orWhere('note', 'like', '%' . $keyword . '%');
        })
        ->paginate(5);
        return view('pages.product.index', ['products' => $products, 'keyword' => $keyword]);
    }

    //create
    public function create()
    {
        return view('pages.product.create');
    }

    //store
    public function store(ProductRequest $request)
    {
        $filename = time() . '.' . $request->picture->extension();
        $request->picture->storeAs('public/products', $filename);
        // $data = $request->all();

        $product = new Product;
        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->duration = (int) $request->duration;
        $product->description = $request->description;
        $product->note = $request->note;
        $product->picture = $filename;
        $product->save();

        return redirect()->route('product.index');
    }

    //edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.product.edit', compact('product'));
    }

    //update
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        // Check if a new picture is uploaded
        if ($request->hasFile('picture')) {
            $filename = time() . '.' . $request->picture->getClientOriginalExtension();
            $request->picture->storeAs('public/products', $filename);
            $product->picture = $filename;
        }

        // Update other fields
        $product->update([
            'name' => $request->name,
            'price' => (int) $request->price,
            'duration' => (int) $request->duration,
            'description' => $request->description,
            'note' => $request->note,
        ]);

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
}

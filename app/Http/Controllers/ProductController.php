<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $products = Product::all();
        return view('products/products', compact('products'));
    }

    public function getProduct()
    {
        $products = Product::all();
        return $this->successResponse('data retrive successfully',$products);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create()
    {
        return view('products/create');
    }

     /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules for your image upload
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules for your image upload
            'quantity' => 'required|integer|min:0',
        ]);


        // Handle the image upload if provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $imagePath = 'storage/images/' . $imageName;
        }

        $thumbPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumb = $request->file('thumbnail');
            $thumbName = time() . '.' . $thumb->getClientOriginalExtension();
            $thumb->storeAs('public/thumbs', $thumbName);
            $thumbPath = 'storage/thumbs/' . $thumbName;
        }

        // Create a new product using the validated data
        $product = new Product([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
            'image' => $imagePath,
            'thumbnail' => $thumbPath,
            'quantity' => $validatedData['quantity'],
        ]);

        // Save the product to the database
        $product->save();

        // Redirect to a success page or return a response
        return $this->successResponse('Product added successfully',$product);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function cart()
    {
        return view('cart');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);
        if ($product->quantity<1) {
            return response()->json([
                'success'=>false,
                'message'=>"Can't add more",
                'data'=>$cart
            ]);
        }


        if(isset($cart[$id])) {
            return response()->json([
                'success'=>false,
                'message'=>"Already in cart",
                'data'=>$cart
            ]);
        } else {
                $cart[$id] = [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "image" => $product->image
                ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');

    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function update(Request $request)
    {
        $product=Product::findOrFail($request->id);
        if($request->id && $request->quantity && $product->quantity>=$request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            // session()->flash('success', 'Cart updated successfully');
            return response()->json([
                'success'=>true,
                'message'=>'Cart updated successfully',
                'data'=>$cart
            ]);
        }
        return response()->json([
            'success'=>false,
            'message'=>"Can't update",
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json([
                'success'=>true,
                'message'=>'Cart deleted successfully',
                'data'=>$cart
            ]);
        }
        return response()->json([
            'success'=>false,
            'message'=>"Can't delete",
            'data'=>session()->get('cart')
        ]);
    }
}

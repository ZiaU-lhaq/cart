<?php

namespace App\Http\Controllers;

// app/Http/Controllers/CartController.php

use App\Models\Cart;
use App\Models\Product;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponseTrait;
    public function addToCart(Request $request)
    {
        // You can validate the input here if needed
        $request->validate([
            'product_id' => 'required',
        ]);

        $userId = auth()->user()->id;

        // Check if the item is already in the cart
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $request->product_id)->first();
        if ($cartItem) {

            return $this->errorResponse('Already in cart', 500);

        } else {
            // If not, create a new cart item
            Cart::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'quantity' => 1,
            ]);
        }

        return $this->successResponse('Product added to cart');

    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'cart_id' => 'required',
            'quantity' => 'required',
        ]);

        $userId = auth()->user()->id;
        $productId = $request->product_id;
        $product=Product::find($productId);
        if($product && $product->quantity && $product->quantity>=$request->quantity){
            $cart=Cart::where('product_id',$productId)->where('user_id',$userId)->first();
            if($cart) {
                $cart->quantity=$request->quantity;
                $cart->update();
                return $this->successResponse('cart edit successfully');
            }
        }

        return $this->errorResponse('An error occurred.', 500);
    }

    public function viewCart()
    {
        $userId = auth()->user()->id;
        $cartItems = Cart::where('user_id', $userId)->get();

        return $this->successResponse('cart edit successfully',$cartItems);
    }

    public function removeFromCart($cartId)
    {
        Cart::destroy($cartId);
        return response()->json(['message' => 'Item removed from cart'], 200);

        // Redirect back to the cart page or wherever you want
    }
}


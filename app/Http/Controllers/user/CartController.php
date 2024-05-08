<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

use App\Repositories\Eloquent\ProductEloquentRepository;

class CartController extends Controller
{
    protected $productRepository;

    public function __construct(
        ProductEloquentRepository $productRepository) {
        $this -> productRepository = $productRepository;
    }


    public function index (Request $request) {
        if (!$request->session()->has('cart')) {
            $cart = [];
        } else {
            $cart = $request->session()->get('cart');
        }
        $productsInCart = [];

        foreach ($cart as $item) {
            
            $product = $this -> productRepository -> findById($item['productid']);
            if ($product) {
                $product->quantityInCart = $item['cart_quantity'];
                $product -> product_size = $item['product_size'];
                $product -> product_color = $item['product_color'];
                $productsInCart[] = $product;
            }
        } 
        $count = count($productsInCart);
        return view('user.cart', compact('productsInCart', 'count'));
    }

    public function addToCart(Request $request, $productId)
    {
        if(empty($request -> size) || empty($request -> color)) return redirect()->back();
        $product = Product::findOrFail($productId);
        $productSize = $request -> size;
        $productColor = $request -> color;


        // Kiểm tra xem giỏ hàng đã tồn tại hay chưa
        if (!$request->session()->has('cart')) {
            $cart = [];
        } else {
            $cart = $request->session()->get('cart');
        }

        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng hay chưa
        $existingProduct = null;

        foreach ($cart as $key => $item) {
            if ($item['productid'] == $productId && $item['product_size'] == $productSize && $item['product_color'] == $productColor) {
                $existingProduct = $key;
                break;
            }
        }

        // Nếu sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
        if ($existingProduct !== null) {
            $cart[$existingProduct]['cart_quantity'] += $request->cart_quantity;
        } else {
            // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm sản phẩm mới
            $cart[] = [
                'productid' => $productId,
                'cart_quantity' => 1,
                'quantity' => $request->cart_quantity,
                'product_size' => $productSize,
                'product_color' => $productColor
            ];
        }

        // Lưu lại giỏ hàng trong session
        $request->session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    public function updateOrder(Request $request)
    {
        if (count($request->all()) > 0) {
            
            $cart = $request->session()->get('cart');

            foreach ($cart as &$item) {
                $product = $this->findProduct($request->all(), $item['productid'], $item['product_size'], $item['product_color']);
                
                if (!empty($product)) {
                    $item['quantity'] = $product['quantity'];
                    $item['checked'] = '1';
                } else {
                    $item['checked'] = '0';
                }
            }

            
            
            $request->session()->put('cart', $cart);
            return response()->json(route('createOrder'));
        }

        return 0;
    }

    public function findProduct($cart, $productId, $size, $color)
    {
        
        foreach ($cart as $product) {
            if ($product['productId'] == $productId && $product['size'] == $size && $product['color'] == $color) {
                return $product;
            }
        }
        
        return null;
    }

    public function updateCartItem(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Kiểm tra xem giỏ hàng có tồn tại hay không
        if (!$request->session()->has('cart')) {
            return redirect()->back()->with('error', 'Giỏ hàng không tồn tại.');
        }

        $cart = $request->session()->get('cart');

        // Cập nhật số lượng sản phẩm trong giỏ hàng
        $cart->updateProduct($product, $request->quantity);

        // Lưu lại giỏ hàng trong session
        $request->session()->put('cart', $cart);

        

        return redirect()->back()->with('success', 'Sản phẩm trong giỏ hàng đã được cập nhật.');
    }

    public function removeCartItem(Request $request, $productId)
    {
        // Kiểm tra xem giỏ hàng có tồn tại hay không
        if (!$request->session()->has('cart')) {
            return redirect()->back()->with('error', 'Giỏ hàng không tồn tại.');
        }

        

        $cart = $request->session()->get('cart');

        $productIndex = null;
        foreach ($cart as $key => $item) {
            if ($item['productid'] == $productId && $item['product_size'] == $request -> size && $item['product_color'] == $request -> color) {
                $productIndex = $key;
                break;
            }
        }

        if ($productIndex !== null) {
            unset($cart[$productIndex]);
            $cart = array_values($cart);
        }

        $request->session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
    }
}

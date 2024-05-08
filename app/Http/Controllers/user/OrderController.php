<?php

namespace App\Http\Controllers\user;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Pdf;
use App\Controllers\VNPayController;

use App\Repositories\Eloquent\ProductEloquentRepository;
use App\Repositories\Eloquent\OrderEloquentRepository;
use App\Repositories\Eloquent\OrderDetailEloquentRepository;
use Mail;
use App\Mail\OrderNotiMail;

use App\Models\Product;

class OrderController extends Controller
{
    protected $productRepository;
    protected $orderRepository;
    protected $orderDetailRepository;

    public function __construct(
        ProductEloquentRepository $productRepository,
        OrderEloquentRepository $orderRepository,
        OrderDetailEloquentRepository $orderDetailRepository) {
        $this -> productRepository = $productRepository;
        $this -> orderRepository = $orderRepository;
        $this -> orderDetailRepository = $orderDetailRepository;
    }

    public function index () {
        $orders = $this -> orderRepository -> findWhere(['user_id' => auth() -> guard('web') -> user() -> id]);
        
        return view('user.order', compact('orders'));
    }

    public function orderDetail(Request $request) {
        $id = $request -> id;
        $orderInfo = $this -> orderRepository->findById($id);
        $products = $this -> orderDetailRepository -> findWhere(['order_id' => $id]);
        return view('user.order-detail', compact('orderInfo', 'products'));
    }

    public function splitStringByDash($inputString) {
        // Sử dụng hàm explode để tách chuỗi thành một mảng các phần tử
        // Dấu "-" là tham số thứ nhất để tách chuỗi
        $resultArray = explode("-", $inputString);
        return $resultArray;
    }

    public function createOrder(Request $request) {
        if(!(auth() -> guard('web') -> check())) return redirect(route('cart'));
        $cart = session() -> get('cart');
        $productsInCart = [];
        $totalPrice = 0;
        $order_title = '';
        foreach ($cart as $item) {
           
            if($item['checked'] == 1) {
                $product = $this -> productRepository -> findById($item['productid']);
                if ($product) {
                    $totalPrice += ($product['price'] * $item['quantity'] - $product['price'] * $item['quantity'] * $product['discount'] / 100);
                    $product->quantityInCart = $item['quantity'];
                    $product->product_size = $item['product_size'];
                    $product->product_color = $item['product_color'];
                    $productsInCart[] = $product;
                    $order_title .= $product -> title.', ';
                }
            }
        } 

        $count = count($productsInCart);

        if(count($cart) <= 0) return redirect() -> route('cart');

        return view('user.order-confirm',  compact('productsInCart', 'count', 'totalPrice'));
    }

    public function submitOrder(Request $request) {
        $validator = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'required|string|max:255',
        ]);

        // http://localhost:8000/paymentorder

        $cart = session() -> get('cart');
        
        $productsInCart = [];
        $totalPrice = 0;
        foreach ($cart as $item) {
            if($item['checked'] == 1) {
                $product = $this -> productRepository -> findById($item['productid']);
                if ($product) {
                    $totalPrice += ($product['price'] * $item['quantity'] - $product['price'] * $item['quantity'] * $product['discount'] / 100);
                    $product->quantityInCart = $item['quantity'] ?? 1;
                    $product->product_size = $item['product_size'];
                    $product->product_color = $item['product_color'];
                    $productsInCart[] = $product;
                }
            }
        }

        $request -> merge([
            'user_id' => auth() -> guard('web') -> user() -> id,
            'total_amount' => $totalPrice,
            'order_note' => $request -> note ?? 'Ghi chú',
            'payment_method' => $request -> pay_method,
            'order_code' => '',
            'order_title' => 'Order Details'
        ]);       

        $request -> merge(
            ['shipping_address' => $request -> shipping_address.
            ', '.$request -> commune.
            ', '.$request -> district.
            ', '.$request -> province]
        );

        $order = $this -> orderRepository -> create($request -> all());
        $orderId = $order->id;
        
        foreach($productsInCart as $product) {
            DB::table('order_details') -> insert([
                'product_id' => $product -> id,
                'size' => $product->product_size,
                'color_code' => $product->product_color,
                'order_id' => $orderId,
                'quantity' => $product -> quantityInCart,
                'item_price' => $product -> price - $product -> price * $product -> discount / 100
            ]);
        }

        foreach ($cart as $key => $item) {
            if ($item['checked'] == 1) {
                session()->forget("cart.$key");
            }
        }

        $user = auth() -> guard('web') -> user();

        $order = $this -> orderRepository -> findById($orderId);
        $order_details = $this -> orderDetailRepository -> findWhere(['order_id' => $orderId]);

        Mail::to(auth() -> guard('web') -> user() -> email)->send(new OrderNotiMail($user,$order_details,$totalPrice, $order));
        
        if($request -> pay_method == '2') 
            return redirect() -> route('createpayment')
            -> with('amount', $totalPrice)
            ->with('orderId', $orderId);
        
        return redirect() -> route('orderDetail', ['id' => $orderId]);
    }

    public function orderInvoiceView (Request $request) {
        $orderId = $request->id;
        $order = $this -> orderRepository -> findById($orderId);
        $order_details = $this -> orderDetailRepository -> findWhere(['order_id' => $orderId]);
        return view('user.order-invoice', compact('order', 'order_details'));
    }
    public function orderInvoiceGenerate (Request $request) {
        $orderId = $request->id;
        $order = $this -> orderRepository -> findById($orderId);
        $order_details = $this -> orderDetailRepository -> findWhere(['order_id' => $orderId]);
        $print = 1;
        return view('user.order-invoice', compact('print', 'order', 'order_details'));
    }
}



<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Charts\SampleChart;

use App\Models\User;

use App\Repositories\Eloquent\OrderEloquentRepository;
use App\Repositories\Eloquent\OrderDetailEloquentRepository;
use App\Repositories\Eloquent\CustomerEloquentRepository;
use App\Repositories\Eloquent\ProductEloquentRepository;

use App\Models\OrderDetail;

class OrderController extends Controller
{
    protected $orderRepository;
    protected $orderDetailRepository;
    protected $customerRepository;

    public function __construct(
        OrderEloquentRepository $orderRepository,
        OrderDetailEloquentRepository $orderDetailRepository,
        CustomerEloquentRepository $customerRepository,
        ProductEloquentRepository $productRepository
        ) {
        $this -> orderRepository = $orderRepository;
        $this -> orderDetailRepository = $orderDetailRepository;
        $this -> customerRepository = $customerRepository;
        $this -> productRepository = $productRepository;
    }

    public function index(Request $request) {
        $orders  = $this -> orderRepository -> paginateWhereOrderBy([], 'updated_at','DESC', 1, 3, ['*']);
        $old_filters = $request -> all();
        return view('admin.orders.index', compact('orders', 'old_filters'));
    }

    public function detail(Request $request) {
        $foundOrder = $this -> orderRepository -> findById($request -> id);
        $products = $this -> orderDetailRepository -> joinFindId('order_id', '=', $foundOrder -> id, 'products', 'product_id', [
            'title',    
        ]);
        
        return view('admin.orders.detail', compact('foundOrder', 'products'));
    }

    public function changeStatus(Request $request) {
        $foundOrder = $this -> orderRepository -> findById($request -> id);
        $update = $this -> orderRepository -> update([
            'order_status' => $request -> status
        ], $foundOrder -> id);
        return redirect() -> route('admin.orders.detail', $foundOrder -> id) -> with('success', 'Cập nhật trạng thái đơn hàng thành công');
    }

    public function filterOrders(Request $request) {
        $orders = $this -> orderRepository -> filterOrders(
            $request -> sort_filter,
            $request -> status_filter,
            $request -> id,
        );
        return $orders;
    }

    // Thống kê
    public function statistics(Request $request) {        
    }

}

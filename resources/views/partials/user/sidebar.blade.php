@php 
    use Illuminate\Support\Facades\DB;
    $categories = DB::table('categories') -> where('deleted_at', null) -> where('status', '1') -> get();
    $hotProducts = DB::table('products') -> where('deleted_at', null) -> where('hot','1') -> where('status', '1') -> limit('5') -> get();
    $topSellProducts = DB::select("SELECT products.*, SUM(order_details.quantity) as total_quantity_sold
        FROM products
        INNER JOIN order_details ON products.id = order_details.product_id
        WHERE products.deleted_at IS NULL AND products.status = '1'
        GROUP BY products.id
        ORDER BY total_quantity_sold DESC
        LIMIT 5;");
    if(auth() -> guard('web') -> check()) {
        $user = auth() -> guard('web') -> user();
        $favouriteProducts = DB::table('products')
        ->join('favourites', 'products.id', '=', 'favourites.product_id')
        ->where('favourites.user_id', $user->id)
        ->get();
    }else {
        $favouriteProducts = [];
    }
    
@endphp


<aside class="sidebar">
    <div class="cates">
        <div class="card-header">
            <p class="icon"><i class="fa-solid fa-bars"></i></p>
            <p class="name">DANH MỤC</p>
        </div>
        
        <div class="card-body">
            @foreach($categories as $category)
                <p class = "cate-item">{{$category -> title}}</p>
            @endforeach
        </div>
        
    </div>
    @if(count($hotProducts) > 0)
        <div class="good-products">
            <div class="card-header">
                <p class="icon"><i class="fa-solid fa-fire"></i></p>
                <p class="name">SẢN PHẨM HOT</p>
            </div>
            <div class="card-body">
                @foreach($hotProducts as $product) 
                    <a href="{{ route('product_detail', ['slug' => $product->slug]) }}" class="item">
                        <div class="img">
                            <img src="{{$product -> thumbnail}}" alt="{{$product -> title}}">
                        </div>
                        <div class="info">
                            <p>{{$product->title}}</p>
                            <p>GIẢM GIÁ 499.000Đ</p>
                            <p>GIÁ GỐC: 599.000Đ</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif 
    @if(count($topSellProducts) > 0)
        <div class="top-sells">
            <div class="card-header">
                <p class="icon"><i class="fa-solid fa-eye"></i></p>
                <p class="name">SẢN PHẨM BÁN CHẠY</p>
            </div>
            <div class="card-body">
                @foreach($topSellProducts as $product) 
                    <a href="{{ route('product_detail', ['slug' => $product->slug]) }}" class="item">
                        <div class="img">
                            <img src="{{$product -> thumbnail}}" alt="{{$product -> title}}">
                        </div>
                        <div class="info">
                            <p>{{$product->title}}</p>
                            <p>GIẢM GIÁ 499.000Đ</p>
                            <p>GIÁ GỐC: 599.000Đ</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
    @if(count($favouriteProducts) > 0)
        <div class="top-sells">
            <div class="card-header">
                <p class="icon"><i class="fa-solid fa-heart"></i></p>
                <p class="name">SẢN PHẨM YÊU THÍCH</p>
            </div>
            <div class="card-body">
                @foreach($favouriteProducts as $product) 
                    <a href="{{ route('product_detail', ['slug' => $product->slug]) }}" class="item">
                        <div class="img">
                            <img src="{{$product -> thumbnail}}" alt="{{$product -> title}}">
                        </div>
                        <div class="info">
                            <p>{{$product->title}}</p>
                            <p>GIẢM GIÁ 499.000Đ</p>
                            <p>GIÁ GỐC: 599.000Đ</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</aside>
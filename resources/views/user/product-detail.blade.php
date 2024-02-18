@extends('layouts.user-layout')
@php

@endphp
@section('style')
    <style>
        .product-detail {
            min-height: 300px;
            padding-left: 20px;
            border: 1px solid #ccc;
            margin-left: 20px;
        }

        .product-detail .top {
            padding: 10px 20px;
            padding-left: 5px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 30px;
        }

        .product-detail .top img {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .product-detail .top .name {
            height: 50px;
        }

        .product-detail .top .right {
            border: 1px solid #ccc;
            padding: 10px;
        }

        .product-detail .top .right .select {
            font-size: 1.7rem;
        }

        .product-detail .top .right .select select {
            width: 100%;
            height: 40px;
            border: 1px solid #ccc;
            font-size: 1.7rem;
            opacity: 0.9;
            border-radius: 5px;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .product-detail .top .right .select .price span:nth-child(1) {
            text-decoration: line-through;
        }

        .product-detail .top .right .select .price span:nth-child(2) {
            font-weight: 500;
            color: red;
        }

        .product-detail .top .right .select select:focus {
            
            outline: 1px solid #ddd;
        }

        .product-detail .top .right button {
            margin-top: 25px;
            padding: 7px 15px;
            font-size: 1.7rem;
            border: none;
            background-color: #333;
            color: #fff;
            border-radius: 3px;
            cursor: pointer;
        }

        .product-detail .top .right button:hover{
            opacity: 0.9;
        }

        .product-detail .top .right button i {
            margin-right: 7px;
        }

        .product-detail .bottom .control {
            display: flex;
            margin-top: 15px;
        }

        .product-detail .bottom .control p a {
            margin-right: 15px;
            color: blue;
            opacity: 0.9;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
        }

        .product-detail .bottom .control .active a {
            color: #333;
            cursor: default;
        }

        .product-detail .bottom .content {
            padding-right: 20px;
        }

        .right {
            position: relative;
        }

        .content {
            padding: 10px 6px;
        }

        .favourite_btn {
            position: absolute;
            z-index: 2;
            right: 8px;
            top: 10px;
            cursor: pointer;
            color: #ccc;
            font-size: 20px;
        }

        .favourite_btn .active {
            color: red;
        }

        .bottom .content {
            display: none;
        }

        .bottom .active-page {
            display: block;
        }

        .user-review {
            display: flex;
            padding-bottom: 4px;
            border-bottom: 1px solid #eee;
            margin-bottom: 9px;
        }

        .user-review .right {
            flex: 1;
            margin-left: 7px;
        }

        .user-review .right .star {
            padding: 4px 0 7px 0;
            opacity: 0.8;
        }

        .user-review .right .star .active {
            color: #FFAE42;
        }

        .user-review img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px dashed #eee;
        }

        .statist {
            border: 1px solid #eee;
            padding: 5px 10px;
            margin-bottom: 15px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }

        .statist .common {
            font-size: 30px;
            display: flex;
        }

        .statist .common p {
            font-size: 15px;
            display: flex;
        }

        .reviewself {
            padding-left: 7px;
        }

        .reviewself h3 {
            margin-bottom: 7px;
            font-size: 18px;
        }

        .reviewself .star {
            font-size: 20px;
        }

        .reviewself input {
            width: 100%;
            height: 40px;
            margin-top: 4px;
            padding: 0 8px;
            font-size: 17px;
            border: 1px solid #ccc;
        }

        .reviewself input:focus {
            outline: 1px solid #ddd;
        }

        .reviewself button {
            height: 30px;
            width: 80px;
            font-size: 17px;
            background-color: #146EBE;
            border-radius: 3px;
            border: none;
            color: #fff;
            cursor: pointer;
        }

        .reviewself button:hover {
            opacity: 0.8;
        }

        .star .active {
            color: #FFAE42;
        }

        
    </style>
@endsection

@php 
        $size_list = ["39", "39-40", "40", "40-41", "41", "40-42", "42", "42-43", "43", "43-44", "44", "44-45", "45", "45-46", "46", "47", "48", "49"];

        if(auth() -> guard('web') -> check()) 
            $isFavourite = DB::table('favourites') 
                -> where('user_id', auth() -> guard('web') -> user() -> id)
                -> where('product_id', $foundProduct -> id) -> get();
        else 
            $isFavourite = [];
@endphp 

@php 
    use Illuminate\Support\Facades\DB;

    use App\Models\Review;

    
@endphp 

@section('main')
    @if(!empty($foundProduct))
        <div class="product-detail">
            <div class="top">
                <div class="left">
                    <div class="img">
                        <img src="{{$foundProduct -> image}}" alt="">
                    </div>
                </div>
                <form method = "POST" action="{{route('addToCart', ['productId' => $foundProduct -> id])}}" class="right">
                    <a href="{{ route('product_favourite', ['slug' => $foundProduct->slug]) }}" class = "favourite_btn">
                        @if(count($isFavourite) > 0)
                            <i class="active fa-solid fa-heart"></i>
                        @else 
                            <i class="fa-solid fa-heart"></i>
                        @endif
                    </a>
                    
                    <div class="name">
                        <h3>{{$foundProduct -> title}}</h3>
                    </div>
                    <div class="select">
                        @if(!empty($foundProduct -> discount))
                            <p>Khuyến mãi: {{$foundProduct -> discount}}%</p>
                        @endif 
                        <select name="size" id="">
                            <option value="0">-Size sản phẩm-</option>
                            @foreach($size_list as $size)
                                <option value="{{$size}}">{{$size}}</option>
                            @endforeach
                        </select>
                        <p class="price">
                            @if(!empty($foundProduct -> discount))
                                <span>Giá gốc: {{number_format($foundProduct -> price)}}đ</span>
                                <span>Giá mới: {{number_format($foundProduct -> price - $foundProduct -> price * $foundProduct -> discount / 100)}}đ</span>
                            @else 
                                <span></span>
                                <span>Giá bán: {{number_format($foundProduct -> price)}}đ</span>
                            @endif
                        </p>
                    </div>
                    @csrf
                    @method('POST')
                    <button type="submit">
                        <i class="fa-solid fa-bag-shopping"></i>Thêm vào giỏ hàng
                    </button>
                </form>
            </div>
            <div class="bottom">
                <div class="control">
                    <p class = "active"><a href="#description">Mô tả sản phẩm</a></p>
                    <p><a href="#guide">Hướng dẫn mua hàng</a></p>
                    <p><a href="#review">Đánh giá</a></p>
                </div>
                <div class="content page-1 active-page">
                    <p>
                        {!!$foundProduct -> description!!}
                    </p>
                </div>
                <div class="content page-2">
                    <h1>Hướng dẫn đặt giày trực tuyến</h1>
                    <p>Chào mừng đến với trang web của chúng tôi! Dưới đây là hướng dẫn đơn giản để đặt giày trực tuyến:</p>
                    
                    <ol>
                        <li>Truy cập vào trang web của chúng tôi: <a href="https://www.example.com">www.example.com</a>.</li>
                        <li>Tìm kiếm sản phẩm giày bạn muốn mua bằng cách sử dụng hộp tìm kiếm hoặc duyệt qua danh mục sản phẩm.</li>
                        <li>Chọn sản phẩm giày bạn muốn mua bằng cách nhấp vào hình ảnh hoặc tên sản phẩm để xem thông tin chi tiết.</li>
                        <li>Chọn kích cỡ và màu sắc phù hợp sau đó nhấp vào nút "Thêm vào giỏ hàng".</li>
                        <li>Kiểm tra lại đơn hàng của bạn bằng cách nhấp vào biểu tượng giỏ hàng ở góc trên bên phải của trang web.</li>
                        <li>Điền thông tin giao hàng và thanh toán, sau đó nhấp vào nút "Hoàn tất đơn hàng".</li>
                        <li>Xác nhận đơn hàng của bạn và chờ nhận xác nhận đặt hàng qua email của bạn.</li>
                        <li>Chờ đợi sản phẩm giày của bạn được giao đến và thưởng thức.</li>
                    </ol>
                    
                    <p>Nếu bạn cần hỗ trợ thêm, vui lòng liên hệ với chúng tôi qua số điện thoại: 0123 456 789 hoặc email: support@example.com.</p>
                </div>
                <div class="content page-3">
                    <div class="statist">
                        <div class="common">
                            <div class = "star">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <p>({{count($reviews)}} Đánh giá)</p>
                        </div>
                        <form method = "POST" action = "{{route('handle-review')}}" class="reviewself">
                            @method('POST') 
                            @csrf
                            <input type="hidden" name="product_id" value = "{{$foundProduct -> id}}">
                            @if(auth() -> guard('web') -> check())
                                <h3>Đánh giá của bạn</h3>
                                <div class = "star">
                                    @php 
                                        if(!empty($reviewself -> rating)) $rating = $reviewself -> rating;
                                        else $rating = 0;
                                    @endphp 
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $rating)
                                        <i class="active fa-solid fa-star"></i>
                                        @else 
                                        <i class="fa-solid fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <input type="hidden" name="id" value = "{{$reviewself -> id ?? ''}}">
                                <input type="text" name = "review_title" placeholder="VD: Sản phẩm tốt..." value = "{{$reviewself -> review_title ?? ''}}"/>
                                <textarea rows="4" style = "margin-top: 4px; width: 100%; padding: 0 5px" name = "review_content"> {{$reviewself -> review_content ?? ''}}</textarea>
                                <button type= "submit">Gửi</button>
                            @else
                            @endif 
                        </div>
                        <div>
                            @if(count($reviews) > 0)
                                @foreach($reviews as $review)
                                    <div class = "user-review">
                                        <div class="left">
                                            <img src="{{$review -> user -> thumbnail}}" alt="">
                                        </div>
                                        <div class="right">
                                            <p><b>{{$review -> user -> name}}</b> &nbsp; <i style = "font-size: 14px">{{date('d/m/Y', strtotime($review->created_at))}}</i></p>
                                            <div class="star">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review -> rating)
                                                    <i class="active fa-solid fa-star"></i>
                                                    @else 
                                                    <i class="fa-solid fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <div class="des">
                                                <p style = "font-weight: 500">{{$review -> review_title}}</p>
                                                <p style = "font-size: 15px">{{$review -> review_content}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else 

                            @endif 

                            
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    @endif
@endsection




@section('scripts')
    <script>

        function handleChangeHash() {
            var newHash = window.location.hash;
            var controls = $$('.bottom .control > p'); // Sử dụng $ thay vì $$
            var contents = $$('.bottom .content'); // Sử dụng $ thay vì $$
            
            controls.forEach(function(control) {
                control.classList.remove('active');
            });
            contents.forEach(function(content) {
                content.classList.remove('active-page');
            });
            
            if (newHash === '#guide') {
                controls[1].classList.add('active');
                contents[1].classList.add('active-page');
            } else if (newHash === '#review') {
                controls[2].classList.add('active');
                contents[2].classList.add('active-page');
            } else {
                controls[0].classList.add('active');
                contents[0].classList.add('active-page');
            }
        }

        handleChangeHash();

        window.addEventListener("hashchange", handleChangeHash);
    </script>
@endsection
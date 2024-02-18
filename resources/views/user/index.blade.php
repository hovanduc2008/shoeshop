@extends('layouts.user-layout')

@section('style')
    <style>
        .home {
            min-height: 300px;
            padding-left: 20px;
        }

        .product-list {
            border: 1px solid #ccc;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 10px;
        }

        .product-list .item {
            text-decoration: none;
            color: #333;
        }

        .product-list .item .info {
            padding: 5px 7px;
        }

        .product-list .item .name {
            display: -webkit-box;
            -webkit-line-clamp: 2; /* Số dòng muốn hiển thị */
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 5px;
            height: 40px;

        }

        .product-list .item .price span:nth-child(1) {
            text-decoration: line-through;
        }

        .product-list .item .price span:nth-child(2) {
            color: red;
            font-weight: 500;
        }

        .product-list .item img {
            width: 100%;
            height:200px;
        }

        .title {
            position: relative;
            margin-bottom: 20px;
            
            padding-bottom: 3px;
            color: blue;
        }

        .title::after {
            position: absolute;
            content: '';
            display: block;
            clear: both;
            width: 100%;
            height: 3px;
            background: #ccc;
            top: 100%;
        }

        .title::before {
            position: absolute;
            z-index: 1;
            content: '';
            display: block;
            clear: both;
            width: 300px;
            height: 3px;
            background: red;
            top: 100%;
        }

    </style>
@endsection

@section('main')
    <div class="home">
        <div class="title">
            <h3>DANH SÁCH SẢN PHẨM</h3>
        </div>
        <div class="product-list">

            @foreach($products as $product)
                <a href="{{ route('product_detail', ['slug' => $product->slug]) }}" class="item">
                    <div class="img">
                        <img src="{{$product -> image}}" alt="">
                    </div>
                    <div class="info">
                        <p class="name">{{$product -> title}}</p>
                        <p class="price">
                            
                            @if(!empty($product -> discount)) 
                                <span>{{number_format($product -> price)}}đ</span>
                                <span>{{number_format($product -> price - $product -> price * $product -> discount / 100)}}đ</span>
                            @else 
                                <span></span>
                                <span>{{number_format($product -> price)}}đ</span>
                            @endif
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
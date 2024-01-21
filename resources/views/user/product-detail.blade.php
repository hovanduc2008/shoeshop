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

        .product-detail .bottom .control p {
            margin-right: 15px;
            color: blue;
            opacity: 0.9;
            font-weight: 500;
            cursor: pointer;
        }

        .product-detail .bottom .control .active {
            color: #333;
            cursor: default;
        }

        .product-detail .bottom .content {
            padding-right: 20px;
        }

        
    </style>
@endsection

@section('main')
    <div class="product-detail">
        <div class="top">
            <div class="left">
                <div class="img">
                    <img src="https://hoang-phuc.com/media/catalog/product/1/_/1_240_9.jpg?optimize=high&fit=bounds&height=1280&width=1280&canvas=1280:1280" alt="">
                </div>
            </div>
            <div class="right">
                <div class="name">
                    <h3>Giày Sneaker</h3>
                </div>
                <div class="select">
                    <p>Khuyến mãi</p>
                    <select name="" id="">
                        <option value="">-Size sản phẩm-</option>
                    </select>
                    <p class="price">
                        <span>Giá gốc: 200.000đ</span>
                        <span>Giá mới: 156.000đ</span>
                    </p>
                </div>
                <button type="submit">
                    <i class="fa-solid fa-bag-shopping"></i>Thêm vào giỏ hàng
                </button>
            </div>
        </div>
        <div class="bottom">
            <div class="control">
                <p class = "active">Mô tả sản phẩm</p>
                <p>Hướng dẫn mua hàng</p>
                <p>Bình luận</p>
            </div>
            <div class="content">
                <p>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eos neque obcaecati adipisci illo alias, doloribus quos, provident dignissimos maxime excepturi saepe explicabo, debitis delectus voluptatibus vero blanditiis asperiores! Tenetur voluptatem incidunt, hic ea, deleniti optio velit non ex quae dolores vel laborum dolorum ducimus mollitia voluptates esse obcaecati aliquid totam!
                </p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        
    </script>
@endsection
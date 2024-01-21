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
            <a href='' class="item">
                <div class="img">
                    <img src="https://ananas.vn/wp-content/uploads/Pro_AV00098_1.jpg" alt="">
                </div>
                <div class="info">
                    <p class="name">BASAS BUMPER GUM EXT NE - LOW TOP - BLACK/GUM</p>
                    <p class="price">
                        <span>13.000đ</span>
                        <span>13.000đ</span>
                    </p>
                </div>
            </a>
            <a href='' class="item">
                <div class="img">
                    <img src="https://supersports.com.vn/cdn/shop/products/M9160C-1_900x.jpg?v=1700124581" alt="">
                </div>
                <div class="info">
                    <p class="name">Giày Thời Trang Unisex Converse Chuck Taylor All Star - Đen</p>
                    <p class="price">
                        <span>13.000đ</span>
                        <span>13.000đ</span>
                    </p>
                </div>
            </a>
            <a href='' class="item">
                <div class="img">
                    <img src="https://supersports.com.vn/cdn/shop/products/M9160C-2_1769ee94-2d11-4094-bdda-6c4738f437d3_900x.jpg?v=1668400591" alt="">
                </div>
                <div class="info">
                    <p class="name">Giày cao gót</p>
                    <p class="price">
                        <span>13.000đ</span>
                        <span>13.000đ</span>
                    </p>
                </div>
            </a>
            <a href='' class="item">
                <div class="img">
                    <img src="https://supersports.com.vn/cdn/shop/products/M9160C-2_1769ee94-2d11-4094-bdda-6c4738f437d3_900x.jpg?v=1668400591" alt="">
                </div>
                <div class="info">
                    <p class="name">Giày cao gót</p>
                    <p class="price">
                        <span>13.000đ</span>
                        <span>13.000đ</span>
                    </p>
                </div>
            </a>
            <a href='' class="item">
                <div class="img">
                    <img src="https://supersports.com.vn/cdn/shop/products/M9160C-2_1769ee94-2d11-4094-bdda-6c4738f437d3_900x.jpg?v=1668400591" alt="">
                </div>
                <div class="info">
                    <p class="name">Giày cao gót</p>
                    <p class="price">
                        <span>13.000đ</span>
                        <span>13.000đ</span>
                    </p>
                </div>
            </a>
            <a href='' class="item">
                <div class="img">
                    <img src="https://supersports.com.vn/cdn/shop/products/M9160C-2_1769ee94-2d11-4094-bdda-6c4738f437d3_900x.jpg?v=1668400591" alt="">
                </div>
                <div class="info">
                    <p class="name">Giày cao gót</p>
                    <p class="price">
                        <span>13.000đ</span>
                        <span>13.000đ</span>
                    </p>
                </div>
            </a>
        </div>
    </div>
@endsection
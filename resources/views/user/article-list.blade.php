@extends('layouts.user-layout')

@section('style')
    <style>
        .main-content {
            padding-left: 20px;
        }

        .article {
            border: 1px solid #ccc;
            min-height: 300px;
            padding: 10px 13px;
        }

        .article .item {
            display: flex;
            border-top: 1px solid #ccc;
            padding-bottom: 7px;
            padding-top: 7px;
            cursor: pointer;
            text-decoration: none;
            color: #333;
        }

        .article .item:nth-child(1) {
            border-top: none;
        }

        .article .img {
            height: 180px;
            display: flex;
            width: 230px;
        }

        .article .img img {
            object-fit: cover;
            width: 200px;
            margin-right: 20px;
        }

        .article .title {
            font-size: 2rem;
            margin-bottom: 8px;
            font-weight: 500;
            display: -webkit-box;
            -webkit-line-clamp: 1; /* Số dòng muốn hiển thị */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .article .text {
            display: -webkit-box;
            -webkit-line-clamp: 3; /* Số dòng muốn hiển thị */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

    </style>
@endsection

@section('main')
    <div class="main-content">
        <div class="article">
            @foreach($articles as $article)
                <a href = "{{route('article-detail', ['slug' => $article -> slug])}}" class="item">
                    <div class="img">
                        <img src="{{$article -> image}}" alt="">
                    </div>
                    <div class="info">
                        <div class="title">{{$article -> title}}</div>
                        <div class="text">{{$article -> description}}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
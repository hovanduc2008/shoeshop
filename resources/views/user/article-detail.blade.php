@extends('layouts.user-layout')

@section('style')
    <style>
        .main-content {
            min-height: 300px;
            padding-left: 20px;
        }

        .article {
            border: 1px solid #ccc;
            min-height: 300px;
            padding: 10px 20px;
        }

        .article img {
            max-width: 100%;
            margin-top: 5px;
            margin-bottom: 7px;
        }


    </style>
@endsection

@section('main')
    <div class="main-content">
        <div class="article">
            <h2>{{$foundArticle -> title}}</h2>
            <br>
            <p><i><b>{{$foundArticle -> description}}</b></i></p>
            <br>
            {!!$foundArticle -> content!!}
        </div>
    </div>
@endsection
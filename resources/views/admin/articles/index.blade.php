@extends('layouts.admin-layout')

@php
    $page_title = "Quản lý bài viết";

    $status_option = [
        "2" => "Tất cả",
        "1" => "Enabled",
        "0" => "Disabled"
    ];

    $sort_option = [
        "latest" => "Mới nhất",
        "oldest" => "Cũ nhất",
        "a_z" => "Từ A-Z",
        "z_a" => "Từ Z-A",
    ];

    $limit_option = [
        5, 10, 20, 30, 50    
    ];

    $pagination = $articles;
@endphp

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="row" method = "GET">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    
                                    <select name="limit" id="limit" class = "form-control">
                                        @foreach($limit_option as $value)
                                            @if(isset($current_filters['limit']) && $value == $current_filters['limit'])
                                                <option selected value="{{$value}}">Hiển thị {{$value}}</option>
                                            @else
                                                <option value="{{$value}}">Hiển thị {{$value}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select name="sort_filter" id="" class = "form-control">
                                        @foreach($sort_option as $key => $option)
                                            @if(isset($current_filters['sort_filter']) && $key == $current_filters['sort_filter'])
                                                <option selected value="{{$key}}">{{$option}}</option>
                                            @else
                                                <option  value="{{$key}}">{{$option}}</option>
                                            @endif
                                            
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col">
                            <div class="row">
                                <input type="text" class = "form-control" placeholder = "Tìm kiếm..." value = "{{$current_filters['search'] ?? ''}}" name = "search">
                            </div>
                        </div>
                        <div class="col-2 ml-3">
                            <div class="row">
                                <button class="btn btn-info" type="submit">Lọc</button>
                                <a class="btn btn-secondary ml-2" href="{{route('admin.articles')}}">Hủy lọc</a>    
                            </div>
                        </div>
                    </form>
                    
                    <hr>
                    <div class="row">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Hình ảnh</th>
                                    <th>Tiêu đề</th>
                                    <th>Ngày thêm</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($articles as $article)
                                    <tr>
                                        <td>#{{$article -> id}}</td>
                                        <td class="product-list-img">
                                            <img src="{{$article -> thumbnail}}" class="img-fluid" alt="tbl">
                                        </td>
                                        <td style = "max-width: 400px; overflow: hidden;">
                                            <h6 class="mt-0 m-b-5">{{$article -> title}}</h6>
                                            <p style = "max-width: 90%; text-wrap: wrap; display: -webkit-box; overflow: hidden; -webkit-line-clamp: 2;  -webkit-box-orient: vertical;" class="m-0 font-14">{{$article -> description}}</p>
                                        </td>
                                        <td>{{date_format(date_create($article -> created_at), 'd/m/Y H:m:s')}}</td>
                                        
                                    
                                        <td>
                                            <a href="{{route('admin.article.edit', $article -> id)}}" class="m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-18"></i></a>
                                            <button class = "btn-danger" data-toggle="modal" data-target=".bs-delete-modal-sm" onclick = "modalConfirmDelete('Xác nhận xóa danh mục', 'Danh mục này sẽ bị xóa và không thể khôi phục', '{{route('admin.article.delete', $article -> id)}})')" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-18"></i></button>
                                        </td>
                                    </tr>
                                @endforeach   
                            </tbody>
                        </table>
                    </div>
                    @include('partials.admin.pagination')
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection
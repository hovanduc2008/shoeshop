
@extends('layouts.admin-layout')

@php
    $page_title = "Quản lý sản phẩm";
    $sub_page_title = "Thêm sản phẩm";

@endphp

@section('main')
    @if(count($categories) > 0)
        <form action="{{route('admin.product.handleCreate')}}" method="post" enctype = "multipart/form-data">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">Basic Information</h4>
                            <p class="text-muted m-b-30 font-14">Fill all information below</p>

                            <div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="title">Tên sản phẩm</label>
                                            <input id="title" name="title" type="text" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Giá bán</label>
                                            <input id="price" name="price" type="text" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="description">Mô tả</label>
                                            <textarea class="form-control" name = "description" id="description" rows="5"></textarea>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="quantity">Số lượng</label>
                                            <input id="quantity" name="quantity" type="text" class="form-control" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label">Danh mục</label>
                                            <select class="form-control select2" name = "category" required>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Hình ảnh</label> <br/>
                                            
                                            <br/>
                                            <input type="file" name="upload_image" class="btn btn-purple m-t-10 waves-effect waves-light" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="content">Content</label>
                                            <textarea class="form-control" name = "content" id="content" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body">

                                        <h4 class="mt-0 header-title">Meta Data</h4>
                                        <p class="text-muted m-b-30 font-14">Fill all information below</p>

                                        <div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="meta_title">Meta title</label>
                                                        <input id="meta_title" name="meta_title" type="text" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="meta_keywords">Meta Keywords</label>
                                                        <input id="meta_keywords" name="meta_keywords" type="text" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="meta_description">Meta Description</label>
                                                        <textarea class="form-control" name = "meta_description" id="meta_description" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success waves-effect waves-light">Create</button>
                                <button type="submit" class="btn btn-secondary waves-effect">Cancel</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @csrf
        </form>
    @endif
    
    @if(!count($categories))
        <h3>Vui lòng <a href="{{route('admin.category.create')}}">thêm Danh mục</a> trước khi tạo Sách</h3>
    @endif
</div>
@endsection
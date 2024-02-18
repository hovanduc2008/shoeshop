
@extends('layouts.admin-layout')

@php
    $page_title = "Quản lý đầu sách";
    $sub_page_title = "Sửa thông tin Sách";
@endphp

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">

                    <h4 class="mt-0 header-title">Basic Information</h4>
                    <p class="text-muted m-b-30 font-14">Fill all information below</p>

                    <form action = "{{route('admin.product.handleEdit', $foundProduct -> id)}}" method = "POST" enctype = "multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ISBN">Mã sản phẩm</label>
                                    <input type="text" disabled value = "{{$foundProduct -> id}}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="title">Tên sản phẩm</label>
                                    <input id="title" name="title" type="text" value = "{{$foundProduct -> title}}" class="form-control" required>
                                </div>
                                
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control" name = "description" id="description" rows="5">
                                        {{$foundProduct -> description}}
                                    </textarea>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="price">Giá bán</label>
                                    <input id="price" name="price" type="text" value = "{{($foundProduct -> price)}}" class="form-control"required >
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Số lượng</label>
                                    <input id="quantity" name="quantity" type="text" value = "{{($foundProduct -> quantity)}}" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label">Danh mục</label>
                                    <select class="form-control select2" name = "category" required>
                                        @foreach($categories as $category)
                                            @if($category -> id == $foundProduct -> category_id)
                                                <option selected value="{{ $category->id }}">{{ $category->title }}</option>
                                            @else
                                                <option  value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="discount">Giảm giá (%)</label>
                                    <input type="number" value = "{{$foundProduct -> discount}}"  name = "discount" min = "0" class="form-control" max = "100">
                                </div>

                                <div class="form-group">
                                    <label for="status">Trạng thái: &nbsp;</label>
                                    
                                    @if($foundProduct -> status == '1')
                                        <input type="checkbox" checked name = "status">
                                    @else 
                                        <input type="checkbox" name = "status">
                                    @endif 
                                </div>

                                <div class="form-group">
                                    <label for="hot">Sản phẩm hot: &nbsp;</label>
                                    @if($foundProduct -> hot == '1')
                                        <input type="checkbox" checked name = "hot">
                                    @else 
                                        <input type="checkbox" name = "hot">
                                    @endif 
                                </div>

                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea class="form-control" name = "content" id="content" rows="5">{{$foundProduct -> content}}</textarea>
                                </div>

                            
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Hình ảnh</label> <br/>
                                    <img src="{{$foundProduct -> image}}" alt="product img" class="img-fluid" style="max-width: 200px;" />
                                    <br/>
                                    <input type="file" name="upload_image" class="btn btn-purple m-t-10 waves-effect waves-light">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-sm-6">
                                
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                
                                <h4 class="mt-0 header-title">Meta Data</h4>
                                <p class="text-muted m-b-30 font-14">Fill all information below</p>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="meta_title">Meta title</label>
                                            <input id="meta_title" name="meta_title" type="text" value = "{{$foundProduct -> meta_title}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <input id="meta_keywords" name="meta_keywords"  type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea class="form-control" name = "meta_description" id="meta_description" rows="5">{{$foundProduct -> meta_description}}</textarea>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success waves-effect waves-light">Save Changes</button>
                        <button type="submit" class="btn btn-secondary waves-effect">Cancel</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
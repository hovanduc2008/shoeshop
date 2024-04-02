@php 

use Illuminate\Support\Facades\DB;

$categories = DB::table('categories') -> where('deleted_at', null)-> where('status', '1') -> get();

    
@endphp 

<header class="header">
    <div class="top-header layout-center">
        <div class="container">
            <div class="left">
                <p><i class="fa-solid fa-location-dot"></i><span>Trường Đại học Công Nghiệp Hà Nội</span></p>
                <p><i class="fa-solid fa-envelope"></i><span>shoeshop@shop.vn</span></p>
            </div>
            <div class="right">
                @if(auth() -> guard('web') -> check())
                <a style = "background: #F46A64; color: #fff" class = 'logOutBtn' href="{{route('handle-logout')}}"><i class="fa-regular fa-user"></i>Đăng xuất</a>
                <a class = 'userBtn' href="#"><i class="fa-regular fa-user"></i>{{auth() -> guard('web') -> user() -> name}}</a>
                @else 
                    <a href="{{route('register-form')}}"><i class="fa-solid fa-unlock"></i>Đăng ký</a>
                    <a href="{{route('login-form')}}"><i class="fa-solid fa-right-to-bracket"></i>Đăng nhập</a>
                @endif
            </div>
        </div>
    </div>
    <div class="bottom-header layout-center">
        <div class="container">
            <div class="search">
                <form action = "{{route('home-page')}}" class="box">
                    <div class="cate">
                        <select name="cate_id" id="">
                            <option value="">Danh mục</option>
                            @if(count($categories) > 0)
                                @foreach($categories as $cate)
                                    @if(request() -> cate_id == $cate->id)
                                        <option selected value="{{$cate -> id}}">{{$cate -> title}}</option>
                                    @else 
                                        <option value="{{$cate -> id}}">{{$cate -> title}}</option>
                                    @endif 
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="search-value">
                        <input placeholder = "Tìm kiếm..." type="text" value = "{{request() -> search ?? ''}}" name = "search">
                        <p class="search_icon"><i class="fa-solid fa-magnifying-glass"></i></p>
                    </div>
                    
                </form>
            </div>
            @include('partials.user.logo')
            <div class="hotline">
                <div class="ht-logo">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div class="ht-info">
                    <p>HOTLINE</p>
                    <p>0987-543-212</p>
                </div>
            </div>
        </div>
    </div>
</header>
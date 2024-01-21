@php
    $menu_list = [
        [
            "title" => "TRANG CHỦ",
            "link" => '#'
        ],
        [
            "title" => "GIỚI THIỆU",
            "link" => '#',
            
        ],
        [
            "title" => "ĐỊA CHỈ",
            "link" => '#',
        ],
        [
            "title" => "TIN TỨC",
            "link" => "#"
        ],
        [
            "title" => "ĐÁNH GIÁ WEBSITE",
            "link" => "#"
        ],
        [
            "title" => "LIÊN HỆ",
            "link" => "#"
        ]
    ];
@endphp

<div class="nav layout-center">
    <div class="container">
        <div class="left">
            @foreach($menu_list as $menu)
                <a href="{{$menu['link']}}">{{$menu['title']}}</a>
            @endforeach
        </div>
        <div class="right">
            <a class="cart" href="">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>MY CART</span>
                <span>0</span>
            </a>
        </div>
    </div>
</div>
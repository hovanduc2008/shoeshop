<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');
*{
    padding: 0;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    box-sizing: border-box;
}

body{
    width: 100%;
    height: 100vh;
    overflow: hidden;
    background-color: black;
}

nav{
    width: 100%;
    height: 10vh;
}

.container{
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.container .logo {
    font-weight: bold;
    font-size: 25px;
    color: #fff;
    margin-left: 20px;
    width: 100px;
    filter: drop-shadow(3px 2px 5px #fff);
}

.container .links a{
    color: white;
    text-decoration: none;
    cursor: pointer;
    position: relative;
    margin: 0 20px;
    transition: 0.3s linear;
}

.links a::before{
    content: "";
    position: absolute;
    left: 0;
    bottom: -4px;
    width: 0;
    background-color: #f74f10;
    height: 3.5px;
    transition: 0.3s linear;
}

.links a:hover::before,
.links a:hover{
    color: #f74f10;
    width: 100%;
}

.container .search i{
    color: white;
    cursor: pointer;
    font-size: 1.3rem;
    margin-right: 20px;
}

/* Section Starts */

section{
    width: 100%;
    height: 90vh;
}

section .content{
    display: flex;
    width: 100%;
    height: 100%;
    justify-content: space-around;
    align-items: center;
}

.content .main-content{
    color: white;
    max-width: 600px;
    width: 100%;
    margin: 0 auto;
}

.main-content h1{
    font-size: clamp(2rem, 1rem + 5vw, 4rem);
}

.main-content h2{
    color: #f74f10;
    font-size: clamp(2rem, 1rem + 5vw, 3.5rem);
}

.main-content p{
    margin-top: 10px;
    color: #635e5c;
}

.main-content .order{
    display: flex;
    margin: 20px 10px;
    width: 100%;
    justify-content: space-around;
    min-height: 7vh;
}

.order h3{
    font-size: 1.8rem;
}

.order a{
    display: flex;
    justify-content: center;
    align-items: center;
    min-width: 50%;
    margin-left: 10px;
    border: none;
    outline: none;
    border-radius: 10px;
    background: linear-gradient(to bottom right, #f74f10 40%, #8a3313) ;
    color: white;
    font-weight: 700;
    padding: 0 2px;
    font-size: clamp(0.6rem, 1rem 5vw, 3rem);
    transition: 0.1s linear;
    text-decoration: none;
}

.order a:hover{
    cursor: pointer;
    box-shadow:  0 0 30px #f74f10;
    background: linear-gradient(to bottom right, #8a3313 ,  #f74f10 40%) ;
}

.content .image img{
    max-width: 450px;
    width: 100%;
    margin-right: 100px;
    transform: rotate(40deg) translateX(900px);
    filter: drop-shadow(-10px -10px 200px #f74f10);
}

@media (max-width:800px){
    .content{
        display: flex;
        width: 100%;
        flex-direction: column-reverse;
    }

    .main-content{
        margin: 0 10px;
    }
}

@media (min-width:884px){
    .content .image img{
        min-width: 500px;
    }
}

@media (max-width:440px){
    .links{
        display: none;
    }

    .content .image img{
        width: 100%;
        margin-right: none;
    }
}
    </style>
    <title>Shoes Store</title>
</head>
<body>
    <nav>
        <div class="container">
            <div class="logo">
                ShoeShop
            </div>
            <div class="links">
                @foreach($categories as $item)
                    <a href="?cate={{$item -> id}}">{{$item -> title}}</a>
                @endforeach
                <a href="{{route('home-page')}}">Sản phẩm</a>
                <a href="{{route('article')}}">Bài viết</a>
            </div>
            <div class="search">
                
            </div>
        </div>
    </nav>
    <section>
        <div class="content">
            <div class="main-content">
                <h1 data-aos="fade-right" data-aos-duration="2000">
                    @if(!empty($category))
                        {{$category -> title}}
                    @endif
                </h1>
                @if(!empty($product))
                    <h2 data-aos="fade-left" data-aos-duration="2000" data-aos-delay="200">{{$product -> title}}</h2>
                    @if(!empty($category))
                        <h4 data-aos="fade-right" data-aos-duration="2000" data-aos-delay="400">{{$category -> description}}</h4>
                    @else
                        <h4 data-aos="fade-right" data-aos-duration="2000" data-aos-delay="400">MAKE THE GROUND SHAKE</h4>
                    @endif
                    <p data-aos="flip-down" data-aos-duration="2000" data-aos-delay="600">{{$product -> description}}</p>
                    <div class="order">
                        <h3 data-aos="zoom-in-right" data-aos-duration="2000" data-aos-delay="800">{{number_format($product -> price - $product -> price * ($product -> discount / 100))}}đ</h3>
                        <a href="{{ route('product_detail', ['slug' => $product->slug]) }}" data-aos="zoom-in-left" data-aos-duration="2000" data-aos-delay="800">ĐẶT HÀNG NGAY</a>
                    </div>
                @endif
            </div>
            <div class="image">
                @if(!empty($product))
                    <img src="{{$product -> image}}" data-aos="zoom-in" data-aos-duration="2000">
                @else
                    <img src="shoes.png" data-aos="zoom-in" data-aos-duration="2000">
                @endif
            </div>
        </div>
    </section>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init({
        offset:1
      });
    </script>
</body>
</html>
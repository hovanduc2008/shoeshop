<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>invoice.pdf</title>
    <link rel="stylesheet" href="{{asset('assets/css/user_reset.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/user_style.css')}}">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-size: 1.6rem;
        }

        .logo a{
            font-size: 2.8rem!important;
        }
        body {
            background: #E2EDE7;
            display: flex;
            justify-content: center;
            display: none;
        }
        .invoice-main {
            width: 600px!important;
            position: relative;
        }

        .invoice-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
            margin-bottom: 70px;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h3 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .invoice-info {
            display: flex;
            margin-bottom: 50px;
            justify-content: space-between;
        }

        .invoice-info p {
            margin-top: 5px;
        }

        tbody td {
            border: 1px dashed #808080;
            border-left: none;
            border-right: none;
            padding: 2px 0;
            padding-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-left: none;
            border-right: none;
        }
        th {
            border-left: none;
            border-right: none;
        }

        .uom {
            width: 100%;
            text-align: right;
            font-size: 1.4rem;
            font-style: italic;
            margin-bottom: 3px;
        }

        thead th {
            padding: 7px 2px;
        }

        

        thead th:nth-child(1),
        tbody td:nth-child(1) {
            width: 240px;
        }
        thead th:nth-child(2),
        tbody td:nth-child(2) {
            text-align: center;
        }   
        thead th:nth-child(3),
        tbody td:nth-child(3) {
            text-align: right;
        }
        thead th:nth-child(4),
        tbody td:nth-child(4) {
            text-align: right;
        }

        tfoot tr {
            border-top: 1px solid #808080;
        }

        tfoot th {
            font-size: 1.7rem;
            padding: 3px 0;
        }

        tfoot td {
            text-align: right;
        }

        .invoice-footer {
            margin-top: 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 7px;
            
        }

        .invoice-footer > div:nth-child(2) {
            text-align: center;
        }

        .invoice-footer p {
            font-size: 1.4rem;
        }

        .paid img {
            height: 150px;
        }

        .paid {
            position: absolute;
            bottom: 25px;
            opacity: 0.9;
            right: -50px;
        }
        
    </style>
</head>
<body>
    <div class="invoice-main">
        <div class="invoice-header">
            <div class="logo">
                @include('partials.user.logo')
            </div>
            <div class="invoice-title">
                <h3>HÓA ĐƠN</h3>
                <p><i>Ngày: {{date_format($order -> created_at, 'd/m/Y')}}</i></p>
            </div>
        </div>
        <div class="invoice-body">
            <div class="invoice-info">
                <div class="left">
                    <h3>HÓA ĐƠN CHO:</h3>
                    <p>Họ tên: {{$order -> user -> name}}</p>
                    <p>Điện thoại: {{$order -> user -> phone_number}}</p>
                    <p>Email: {{$order -> user -> email}}</p>
                </div>
                <div class="right">
                    <h3>THANH TOÁN CHO:</h3>
                    <p>Shoe Shop</p>
                    <p>Trường Đại học Công Nghiệp Hà Nội</p>
                    <p>shoeshop.vn</p>
                </div>
            </div>
            <div class="invoice-product-list">
                <p class = "uom">Đơn vị tính: Đồng</p>
                <table border = "1">
                    <thead>
                        <tr>
                            <th>Tên Sản Phẩm</th>
                            <th>Size</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order_details as $item)
                            <tr>
                                <td style = "padding-right: 4px;">{{$item -> product -> title}}({{$item -> color_code}})</td>
                                <td style = "padding-right: 4px;">{{$item -> size}}</td>
                                <td style = "padding-right: 4px; text-align: right">{{$item -> quantity}}</td>
                                <td style = "padding-right: 4px; text-align: right">{{number_format($item -> item_price)}} đ</td>
                                <td style = "padding-right: 4px; text-align: right">{{number_format($item -> item_price * $item -> quantity)}} đ</td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan = "3">
                                TỔNG CỘNG
                            </th>
                            <td colspan = "2" style = "padding-right: 4px; text-align: right">
                                {{number_format($order -> total_amount)}} đ
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="invoice-footer">
            <div>
                <p>Vui lòng email đến shoeshop@shop.vn nếu bạn có câu hỏi hoặc thắc mắc về hóa đơn.</p>
                <p><strong><i>Cảm ơn sự ủng hộ của bạn!</i></strong></p>
            </div>
            <div>
                <h4>Shoe Shop</h4>
                <p>Trường Đại học Công Nghiệp Hà Nội</p>
            </div>
        </div>
        @if(($order -> payment_status == '1' && $order -> payment_method == '1') || 
            ($order -> payment_status == '1' && $order -> payment_method == '2') && $order -> vnp_TransactionStatus == '00'
        )
            <div class = "paid">
                <img src="{{asset('assets/images/iloveyou.png')}}" alt="">
            </div>
        @endif
    </div>

    @if(isset($print))
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script>
            function printInvoice() {
                const myPromise = new Promise((resolve, reject) => {
                    // Giả sử thực thi thành công
                    const result = "Thành công!";
                    resolve(result);
                });

                myPromise
                    .then((r) => {
                    document.querySelector('body').style.display = 'flex';
                    return r; // Trả về kết quả để chuyển tiếp cho then kế tiếp
                    })
                    .then((r) => {
                    window.print();
                    return r; // Trả về kết quả để chuyển tiếp cho then kế tiếp
                    })
                    .then(() => {
                    // Đợi sự kiện in xong
                    window.addEventListener('afterprint', () => {
                        // Chuyển hướng sau khi in xong
                        window.location.href = "{{ route('orderDetail', ['id' => request() -> id]) }}";
                    });
                    })
                    .catch((error) => {
                    console.log("Đã xảy ra lỗi: " + error);
                    });
                }

            document.addEventListener('DOMContentLoaded', printInvoice);
        </script>

    @else
        <script>
            document.querySelector('body').style.display = 'flex';
        </script>
    @endif

</body>
</html>


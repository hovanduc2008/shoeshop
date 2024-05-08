@extends('layouts.user-layout')

@section('style')
    <style>
        .order {
            min-height: 300px;
            padding-left: 20px;
        }
        .order .container {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
        }

        .bill {
            
        }

        .order-header {
            height: 50px;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            border-bottom: 1px solid #eee;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            margin-bottom: 7px;
        }

        .order-footer {
            height: 30px;
            background: #ddd;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            margin-top: 20px;
        }

        .order-header a {
            text-decoration: none;
            margin-left: 10px;
        }

        .order-header .title {
            font-size: 1.8rem;
            font-weight: 600;
        }

        .order-body {
            padding: 0 7px;
        }

        .order-body .order-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 13px;
        }

        .order-body .subtitle {
            border-bottom: 2px solid #ddd;
            padding-top: 18px;
            padding-bottom: 5px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .order-info .info p {
            line-height: 2.5rem;
            font-weight: 500;
        }

        .order-info .info .status {
            margin-top: 7px;
            border: 1px solid #ccc;
            padding: 2px 5px;
        }

        .success {
            color: #558B47;
            border: 1px solid #DBECCD;
            background-color: #DFF0D8;
        }

        .error {
            color: #B94A48;
            border: 1px solid #EED4D8;
            background-color: #F2DEDE;
        }

        .warning {
            color: #946F31;
            border: 1px solid #DAD08F;
            background-color: #F6F1D4;
        }

        th {
            font-weight: 500;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        tr {
            background-color: #dddffd;
        }

        tr:nth-child(2n+1) {
            background-color: #eeeffe;
        }

        table tr td:nth-child(1) {
            text-align: center;
            font-weight: 600;
        }

        table tr td:nth-child(2) {
            text-align: center;
            width: 80px;
        }

        table tr td:nth-child(2) img {
            height: 70px;
            padding: 5px;
        }

        table tr td:nth-child(3) {
            text-align: left;
            padding-left: 7px;
            text-wrap: wrap;
            font-weight: 500;
        }

        table tr td:nth-child(4),
        table tr td:nth-child(6) {
            text-align: right;
            padding-right: 7px;
        }

        table tr td:nth-child(5) {
            width: 100px;
            text-align: center;
        }

        table tr td:nth-child(6) {
            font-weight: 500;
        }

        th {
            padding: 13px 0;
        }

        tr:nth-last-child(1) th{
            font-weight: 500;
            font-size: 1.8rem;
        }

        tr:nth-last-child(1) th:nth-child(2) {
            text-align: right;
            padding-right: 7px;
        }

        .control a {
            color: blue;
        }
   
    </style>
@endsection

@php 

    $vnp_TransactionStatus_List = [
        '00' => 'Giao dịch thành công',
        '02' => 'Chưa thanh toán',
        '07' => 'Trừ tiền thành công. Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).',
        '09' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng.',
        '10' => 'Giao dịch không thành công do: Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần',
        '11' => 'Giao dịch không thành công do: Đã hết hạn chờ thanh toán. Xin quý khách vui lòng thực hiện lại giao dịch.',
        '12' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng bị khóa.',
        '13' => 'Giao dịch không thành công do Quý khách nhập sai mật khẩu xác thực giao dịch (OTP). Xin quý khách vui lòng thực hiện lại giao dịch.',
        '24' => 'Giao dịch không thành công do: Khách hàng hủy giao dịch',
        '51' => 'Giao dịch không thành công do: Tài khoản của quý khách không đủ số dư để thực hiện giao dịch.',
        '65' => 'Giao dịch không thành công do: Tài khoản của Quý khách đã vượt quá hạn mức giao dịch trong ngày.',
        '75' => 'Ngân hàng thanh toán đang bảo trì.',
        '79' => 'Giao dịch không thành công do: KH nhập sai mật khẩu thanh toán quá số lần quy định. Xin quý khách vui lòng thực hiện lại giao dịch',
        '99' => 'Lỗi không xác định.'
    ];
@endphp

@section('main')
    <div class="order">
        <div class="bill">
            <div class="order-header">
                <div class="title">Chi Tiết Đơn Hàng</div>
                <div class="control">
                    <a target = "_blank" href="{{route('order-invoice-view', ['id' => $orderInfo -> id])}}">Xem hóa đơn</a>
                    <a href="{{route('order-invoice-generate', ['id' => $orderInfo -> id])}}">In hóa đơn</a>
                    <a href="{{route('order')}}">Trở lại</a>
                </div>
            </div>
            <div class="order-body">
                <div class="order-info">
                    <div class="left">
                        <p class="subtitle">Thông tin đơn hàng</p>
                        <div class="info">
                            <p>Mã ĐH: {{$orderInfo -> id ?? ''}}</p>
                            <p>Ngày đặt hàng: {{ \Carbon\Carbon::parse($orderInfo->created_at)->format('d/m/Y') ?? '' }}</p>
                            <p class="note">Ghi chú: <span>{{ $orderInfo->order_note ?? '' }}</span></p>
                            <p>Nhận hàng: {{ $orderInfo->successfully_delivery_at != null ? \Carbon\Carbon::parse($orderInfo->successfully_delivery_at)->format('d/m/Y') : '' }}</p>
                            <p>Phương thức thanh toán: 
                                @if($orderInfo->payment_method == '1')
                                    Thanh toán khi nhận hàng
                                @else
                                    Thanh toán online
                                @endif
                            </p>
                            @if($orderInfo -> order_status == 2) 
                                <p class="status success">Order Status Message: Completed</p>
                            @endif
                            @if($orderInfo -> payment_status == 1 && $orderInfo -> payment_method == '2' && $orderInfo -> vnp_TransactionStatus == '00') 
                                <p class="status success">Đã thanh toán
                                    <br>
                                    <span style = "font-weight: 400">Mã giao dịch: #{{$orderInfo -> order_code}}</span>
                                </p>
                            @else
                                <p class="status error">
                                    @foreach($vnp_TransactionStatus_List as $key => $value) 
                                        @if($key == $orderInfo -> vnp_TransactionStatus)
                                            {{$value}}
                                        @endif
                                    @endforeach
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="right">
                        <p class="subtitle">Thông tin người nhận</p>
                        <div class="info">
                            <p>Họ tên: {{$orderInfo -> user -> name}}</p>
                            <p>Email: {{$orderInfo -> user -> email}}</p>
                            <p>Điện thoại: {{$orderInfo -> user -> phone_number}}</p>
                            <p>Địa chỉ: {{$orderInfo -> shipping_address}}</p>
                        </div>
                    </div>
                </div>
                <div class="order-items">
                    <p class="subtitle">Sản phẩm</p>
                    <div class="products">
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                            </tr>
                            @php 
                                $total = 0;
                            @endphp
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$product -> product_id}}</td>
                                    <td><img src="{{$product -> product -> thumbnail}}" alt="{{$product -> product -> title}}"></td>
                                    <td>[{{$product -> size }}] {{$product -> product -> title}}({{$product -> color_code }})</td>
                                    <td>{{number_format($product -> item_price)}} đ</td>
                                    <td>{{$product -> quantity}}</td>
                                    <td>{{number_format($product -> item_price * $product -> quantity) }} đ</td>
                                </tr>
                                @php 
                                    $total += $product -> item_price * $product -> quantity;
                                @endphp
                            @endforeach 
                            <tr>
                                <th colspan="5">Thành Tiền</th>
                                <th>{{number_format($total)}}đ</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="order-footer"></div>
        </div>
    </div>
@endsection

@section('scripts')
    
@endsection

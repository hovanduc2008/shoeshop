@extends('layouts.admin-layout')

@php
    $page_title = "Thống kê";

    
@endphp

@section('main')
<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="mini-stat clearfix bg-white">
            <span class="mini-stat-icon bg-primary"><i class="mdi mdi-cart-outline"></i></span>
            <div class="mini-stat-info text-right">
                <span class="counter text-primary">{{$countCustomer}}</span>
                Tổng số khách hàng
            </div>
            <div class="clearfix"></div>
            <p class=" mb-0 m-t-20 text-muted"> <span class="pull-right"></span></p>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="mini-stat clearfix bg-white">
            <span class="mini-stat-icon bg-success"><i class="mdi mdi-currency-usd"></i></span>
            <div class="mini-stat-info text-right">
                <span class="counter text-success">{{number_format($totalRevenue)}}đ</span>
                Doanh số
            </div>
            <div class="clearfix"></div>
            <p class="text-muted mb-0 m-t-20"> <span class="pull-right"></span></p>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="mini-stat clearfix bg-white">
            <span class="mini-stat-icon bg-warning"><i class="mdi mdi-cube-outline"></i></span>
            <div class="mini-stat-info text-right">
                <span class="counter text-warning">{{$countOrder}}</span>
                Số lượng đơn hàng
            </div>
            <div class="clearfix"></div>
            <p class="text-muted mb-0 m-t-20"> <span class="pull-right"></span></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-xl-6">
        <table border = '1' style = "width: 100%">
            <tr>
                <th colspan = "4" style = "text-align: center; font-size: 18px">
                    <h4>Top mua hàng</h4>
                </th>
            </tr>
            <tr>
                <th style = "text-align: center">ID</th>
                <th style = "text-align: center">Họ tên</th>
                <th style = "text-align: center">Số đơn</th>
                <th style = "text-align: center">Tổng tiền</th>
            </tr>
            @foreach($topCustomers as $item)
                <tr>
                    <td style = "text-align: center">{{$item -> id}}</td>
                    <td style = "text-align: left; padding-left: 20px;">{{$item -> name}}</td>
                    <td style = "text-align: right; padding-right: 10px">{{$item -> I2}}</td>
                    <td style = "text-align: right; padding-right: 10px">{{number_format($item -> I)}}đ</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="col-md-6 col-xl-6">
        <table border = '1' style = "width: 100%">
            <tr>
                <th colspan = "5" style = "text-align: center; font-size: 18px">
                    <h4>Top sản phẩm bán chạy</h4>
                </th>
            </tr>
            <tr>
                <th style = "text-align: center">ID</th>
                <th style = "text-align: center">Size</th>
                <th style = "text-align: center">Tên sản phẩm</th>
                <th style = "text-align: center">Số lượng bán</th>
                <th style = "text-align: center">Tổng tiền</th>
            </tr>
            @foreach($topProducts as $item)
                <tr>
                    <td style = "text-align: center">{{$item -> id}}</td>
                    <td style = "text-align: center">{{$item -> size}}</td>
                    <td style = "text-align: left; padding-left: 20px;">{{$item -> title}}</td>
                    <td style = "text-align: right; padding-right: 10px">{{$item -> I2}}</td>
                    <td style = "text-align: right; padding-right: 10px">{{number_format($item -> I)}}đ</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
<div class="row">
    

    
    
</div>
@endsection

@section('scripts')
        
        
        
@endsection

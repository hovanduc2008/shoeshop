@extends('layouts.user-layout')

@section('style')
    <style>
        .main-content {
            min-height: 300px;
            padding-left: 20px;
        }

        


    </style>
@endsection

@section('main')
    <div class="main-content">
        <div class="auth">
            <div class="title">
                <h3>Đăng ký thành viên</h3>
            </div>
            <form action="">
                <table>
                    <tr>
                        <td><label for="">Họ và Tên</label></td>
                        <td>
                            <input type="text" placeholder="VD: Nguyễn Văn A">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">Email</label></td>
                        <td>
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">Password</label></td>
                        <td>
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">Địa chỉ</label></td>
                        <td>
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">Số điện thoại</label></td>
                        <td>
                            <input type="text">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">Avatar</label></td>
                        <td>
                            <input type="file">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-register">Đăng ký</button>
                        </td>
                    </tr>
                </table>   
            </form>
        </div>
    </div>
@endsection
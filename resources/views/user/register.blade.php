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
            <form action="{{route('handle-register')}}" enctype = "multipart/form-data" method = "POST">
                <table>
                    <tr>
                        <td><label for="">Họ và Tên</label></td>
                        <td>
                            <input name = "name" type="text" placeholder="VD: Nguyễn Văn A">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">Email</label></td>
                        <td>
                            <input name = "email" type="text" placeholder="VD: vana123@gmai.com">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">Password</label></td>
                        <td>
                            <input name = "password" type="password" placeholder="********">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">Địa chỉ</label></td>
                        <td>
                            <input name = "address" type="text">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">Số điện thoại</label></td>
                        <td>
                            <input name = "phone_number" type="text">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">Avatar</label></td>
                        <td>
                            <input name = "upload_image" type="file">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-register">Đăng ký</button>
                        </td>
                    </tr>
                </table> 
                @method('POST') 
                @csrf
            </form>
        </div>
    </div>
@endsection
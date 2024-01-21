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
                <h3>Đăng nhập</h3>
            </div>
            <form action="">
                <table>
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
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-login">Đăng nhập</button>
                        </td>
                    </tr>
                </table>   
            </form>
        </div>
    </div>
@endsection
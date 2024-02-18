<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\ImageController;

use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\ForgetPasswordMail;
use Mail;

class AuthController extends Controller
{
    public function login() {
        if(Auth::guard('web') -> check()){
            Auth::guard('web') -> logout();
        }
        return view('user.login');
    }

    public function register() {
        if(Auth::guard('web') -> check()){
            Auth::guard('web') -> logout();
        }
        return view('user.register');
    }

    public function handleLogin(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect(route('home-page'));
        }

        return back()
            ->withErrors([
                'email' => 'Email hoặc mật khẩu không chính xác!',
            ])
            ->withInput($request->only('email'));
    }

    public function handleRegister(Request $request, ImageController $img)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone_number' => 'required|string|max:255|unique:users',
            //'password_confirmation' => 'same:password|min:6'
        ]);

        $data_create = array_merge($img -> upload($request), [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number
        ]);

        $user = User::create($data_create);

        $notify = "
            
        ";

        return redirect()->route('login-form')->withFragment('register')->withInput()->with('success', $notify);
    }

    public function handleLogout (Request $request) {
        if(Auth::guard('web') -> check()){
            Auth::guard('web') -> logout();
        }
       
        return redirect(route('home-page'));
    }

    public function handleForgetPassword(Request $request) {
        $request->validate([
            'email' => 'required|string|email|max:255',
        ]);
        $email = $request->email;
        $user = User::where('email', $email)->first(); 

        if(!$user) {
            return redirect()->back()->withFragment('forgot-password') ->withInput($request->only('email'))->withErrors(['error' => 'Email này chưa được đăng ký trên hệ thống!']);
        }

        // Tạo token khôi phục mật khẩu
        $token = Password::createToken($user);

        // Tạo mật khẩu mới
        $newpassword = '';

        // Tạo mật khẩu với độ dài tối thiểu là 8 ký tự
        do {
            $newpassword = Str::random(10); // Đặt độ dài mật khẩu tùy ý tại đây
        } while (!preg_match('/^(?=.*[a-zA-Z])(?=.*[0-9])/', $newpassword));
        $hashedPassword = Hash::make($newpassword);
        // Tạo URL xác nhận khôi phục mật khẩu với token và mật khẩu mới
        $resetlink = url('/password/reset', $token).'?email='.urlencode($email).'&password='.urlencode($newpassword);
        
        if (!empty($user)) {
            Mail::to($email)->send(new ForgetPasswordMail($user, $newpassword, $resetlink));
            return redirect()->route('auth')->withFragment('forgot-password')->with('status', 'Mật khẩu mới đã được gửi tới email của bạn! Vui lòng kiểm tra email và xác nhận khôi phục mật khẩu!');
        }
        $notify = "
            Tạo tài khoản thành công
            <p style = 'margin: 0'>Email: ".$request -> email."</p>
            <p style = 'margin: 0'>Password: ".$request -> password."</p>
        ";
        return -1;
    }

    public function handleResetPassword(Request $request) {
        $request->validate([
            'email' => 'required|string|email|max:255',
        ]);
        
        // Lấy thông tin từ URL
        $email = $request->input('email');
        $password = $request->input('password');
        $token = $request->token;
        

        $user = User::where('email', $email)->first(); 


        $response = Password::broker()->tokenExists($user, $token);
        
        if ($response) {
            $this -> resetPassword($user, $password);
        } else {
            return redirect()->back()->withInput($request->only('email'))->withErrors(['error' => trans($response)]);
        }

        

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('auth')->with('status', 'Mật khẩu đã được khôi phục thành công!');
        } else {
            return redirect()->back()->withInput($request->only('email'))->withErrors(['email' => trans($response)]);
        }
    }

    protected function broker()
    {
        return Password::broker();
    }

    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        DB::table('password_resets') ->where('email', $user->email)->delete();
        $user->setRememberToken(Str::random(60));
        $user->save();
    }

    public function profile() {
        return 1;
    }
}

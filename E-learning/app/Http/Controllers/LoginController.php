<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {

        return view('login.index');
    }
    public function verify(LoginRequest $req)
    {
        $user = User::where('user_name', $req->uname)
            ->where('password', $req->password)
            ->first();
        $user->save();


        if ($user->count() > 0) {
            if ($user->type == 'admin') {
                $req->session()->put('uname', $req->uname);
                $req->session()->flash('msg', 'Login Successful');
                return redirect()->route('admin.index');
            } else if ($user->type == 'instructor') {
                $req->session()->put('uname', $req->uname);
                $req->session()->flash('msg', 'Login Successful');
                return redirect()->route('instructor.index');
            }
        } else {
            $req->session()->flash('msg', 'invaild username or password');
            return redirect('/login');
        }
    }
}
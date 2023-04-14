<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register_view()
    {
        return view('/admin/auth/register');
    }

    public function register(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'username' => ['required', 'min:3', 'max:20'],
            'password' => ['required','min:3', 'max:20'],
        ]);

        // assign
        $username = $request->input('username');
        $password = Hash::make($request->input('password'));

        // insert to db
        DB::table('user')->insert([
            'username' => $username,
            'password' => $password
        ]);

        // redirect with success message
        return back()->with('success', 'created account successfully!');
    }

    public function login_view()
    {
        return view('/admin/auth/login');
    }

    public function login(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'username' => ['required', 'min:3', 'max:20'],
            'password' => ['required','min:3', 'max:20'],
        ]);

        // assign
        $username = $request->input('username');
        $password = $request->input('password');

        // cek on db
        $exist = DB::table('user')
                ->where('username', '=', $username)
                ->limit(1)
                ->count();

        // find on db
        $user = DB::table('user')
                ->where('username', '=', $username)
                ->limit(1)
                ->get();

        // wrong username
        if (!$exist) {
            return back()->with('error', 'invalid username/password!');
        }
        
        // wrong username
        if (!Hash::check($password, $user[0]->password)) {
            return back()->with('error', 'invalid username/password!');
        }

        // store data session
        $request->session()->put('username', $username);
        $request->session()->put('user_id', $user[0]->id);

        // all good
        return redirect('/dashboard');
    }

    public function cek(Request $request)
    {
        return $request->session()->all();
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login/');
    }
}

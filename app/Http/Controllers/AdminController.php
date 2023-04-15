<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function profile(Request $request)
    {
        $user_id = $request->session()->get('user_id');

        // find on db
        $user = DB::table('user')
                ->where('id', '=', $user_id)
                ->limit(1)
                ->get();

        return view('/admin/profile', [
            'username' => $user[0]->username,
            'image' => $user[0]->profile_image,
            'user_id' => $user_id
        ]);
    }

    public function edit_profile(Request $request)
    {
        $user_id = $request->session()->get('user_id');

        // find on db
        $user = DB::table('user')
                ->where('id', '=', $user_id)
                ->limit(1)
                ->get();

        return view('/admin/edit_profile', [
            'username' => $user[0]->username,
            'image' => $user[0]->profile_image,
            'user_id' => $user_id
        ]);
    }

    public function edit_profile_save(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'username' => ['required', 'min:3', 'max:20']
        ]);

        // assign var
        $user_id = $request->session()->get('user_id');
        $username = $request->input('username');

        // find on db
        $data_server = DB::table('user')
                ->where('id', '=', $user_id)
                ->limit(1)
                ->get();

        if ($request->hasFile('image')) {
            // compress then upload
            $filename = $user_id . '_' . uniqid() . '.jpg';
            $img = Image::make($request->file('image'))->fit(200)->encode('jpg');
            Storage::put('public/upload/' . $filename, $img);

            // update data image on server
            DB::table('user')
              ->where('id', $user_id)
              ->update(['profile_image' => $filename]);

            // delete old image
            $oldAvatar = $data_server[0]->profile_image;   
            if ($oldAvatar != "user.png") {
                $oldAvatarLocation = 'public/upload/'.$oldAvatar;
                Storage::delete($oldAvatarLocation);
            }

            // store data session
            $request->session()->put('profile_image', $filename);
        }

        // update username
        DB::table('user')
              ->where('id', $user_id)
              ->update(['username' => $username]);
        
        // store data session
        $request->session()->put('username', $username);
        
        return back()->with('success', 'profile updated successfully!');
    }

    public function change_password(Request $request)
    {
        return view('/admin/change_password');
    }

    public function change_password_save(Request $request)
    {
        // assign var
        $user_id = $request->session()->get('user_id');
        $old_password = $request->input('old_password');
        $new_password = $request->input('new_password');
        $password = Hash::make($request->input('new_password'));

        // validasi
        $validated = $request->validate([
            'new_password' => ['required', 'confirmed', 'min:3', 'max:20'],
            'old_password' => ['required'],
        ]);

        // find on db
        $user = DB::table('user')
                ->where('id', '=', $user_id)
                ->limit(1)
                ->get();

        // wrong password
        if (!Hash::check($old_password, $user[0]->password)) {
            return back()->with('error', 'wrong password!');
        }

        // update password
        DB::table('user')
              ->where('id', $user_id)
              ->update(['password' => $password]);

        return back()->with('success', 'password changed successfully!');
    }
}

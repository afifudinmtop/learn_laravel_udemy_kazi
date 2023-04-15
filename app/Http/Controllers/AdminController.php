<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
}

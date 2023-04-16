<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        // find on db
        $data_server_homeslide = DB::table('homeslide')
                ->where('id', '=', '1')
                ->limit(1)
                ->get();

        // store data session
        $request->session()->put('homeslide_title', $data_server_homeslide[0]->title);
        $request->session()->put('homeslide_caption', $data_server_homeslide[0]->caption);
        $request->session()->put('homeslide_video_url', $data_server_homeslide[0]->video_url);
        $request->session()->put('homeslide_image', $data_server_homeslide[0]->image);

        // find on db
        $data_server_about = DB::table('about')
                ->where('id', '=', '1')
                ->limit(1)
                ->get();

        // store data session
        $request->session()->put('about_title', $data_server_about[0]->title);
        $request->session()->put('about_sub_title', $data_server_about[0]->sub_title);
        $request->session()->put('about_caption', $data_server_about[0]->caption);
        $request->session()->put('about_image', $data_server_about[0]->image);
        $request->session()->put('about_long_description', $data_server_about[0]->long_description);

        return view('/frontend/index');
    }

    public function homeslide_edit()
    {
        // find on db
        $homeslide = DB::table('homeslide')
                ->where('id', '=', '1')
                ->limit(1)
                ->get();

        return view('/admin/homeslide', [
            'title' => $homeslide[0]->title,
            'caption' => $homeslide[0]->caption,
            'image' => $homeslide[0]->image,
            'video_url' => $homeslide[0]->video_url
        ]);
    }

    public function homeslide_save(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'title' => ['required', 'min:3'],
            'caption' => ['required', 'min:3'],
            'video_url' => ['required', 'min:3'],
        ]);

        // assign var
        $title = $request->input('title');
        $caption = $request->input('caption');
        $video_url = $request->input('video_url');

        // find on db
        $data_server = DB::table('homeslide')
                ->where('id', '=', '1')
                ->limit(1)
                ->get();

        if ($request->hasFile('image')) {
            // compress then upload
            $filename = uniqid() . '.jpg';
            $img = Image::make($request->file('image'))->fit(630)->encode('jpg');
            Storage::put('public/homeslide/' . $filename, $img);

            // update data image on server
            DB::table('homeslide')
                ->where('id', '=', '1')
                ->update(['image' => $filename]);

            // delete old image
            $oldAvatar = $data_server[0]->image;   
            if ($oldAvatar != "banner.png") {
                $oldAvatarLocation = 'public/homeslide/'.$oldAvatar;
                Storage::delete($oldAvatarLocation);
            }
        }

        // update username
        DB::table('homeslide')
                ->where('id', '=', '1')
                ->update(['title' => $title, 'caption' => $caption, 'video_url' => $video_url]);
        
        return back()->with('success', 'homeslide updated successfully!');
    }

    public function about_edit()
    {
        // find on db
        $about = DB::table('about')
                ->where('id', '=', '1')
                ->limit(1)
                ->get();

        return view('/admin/about', [
            'title' => $about[0]->title,
            'sub_title' => $about[0]->sub_title,
            'caption' => $about[0]->caption,
            'image' => $about[0]->image,
            'long_description' => $about[0]->long_description,
        ]);
    }

    public function about_save(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'title' => ['required', 'min:3'],
            'sub_title' => ['required', 'min:3'],
            'caption' => ['required', 'min:3'],
            'long_description' => ['required', 'min:3'],
        ]);

        // assign var
        $title = $request->input('title');
        $sub_title = $request->input('sub_title');
        $caption = $request->input('caption');
        $long_description = $request->input('long_description');

        // find on db
        $data_server = DB::table('about')
                ->where('id', '=', '1')
                ->limit(1)
                ->get();

        if ($request->hasFile('image')) {
            // compress then upload
            $filename = uniqid() . '.jpg';
            $img = Image::make($request->file('image'))->fit(630)->encode('jpg');
            Storage::put('public/about/' . $filename, $img);

            // update data image on server
            DB::table('about')
                ->where('id', '=', '1')
                ->update(['image' => $filename]);

            // delete old image
            $oldAvatar = $data_server[0]->image;   
            if ($oldAvatar != "default.png") {
                $oldAvatarLocation = 'public/about/'.$oldAvatar;
                Storage::delete($oldAvatarLocation);
            }
        }

        // update username
        DB::table('about')
                ->where('id', '=', '1')
                ->update([
                    'title' => $title,
                    'sub_title' => $sub_title,
                    'caption' => $caption,
                    'long_description' => $long_description,
                ]);
        
        return back()->with('success', 'about updated successfully!');
    }

    public function about(Request $request)
    {
        // find on db
        $data_server_about = DB::table('about')
                ->where('id', '=', '1')
                ->limit(1)
                ->get();

        // store data session
        $request->session()->put('about_title', $data_server_about[0]->title);
        $request->session()->put('about_sub_title', $data_server_about[0]->sub_title);
        $request->session()->put('about_caption', $data_server_about[0]->caption);
        $request->session()->put('about_image', $data_server_about[0]->image);
        $request->session()->put('about_long_description', $data_server_about[0]->long_description);

        return view('/frontend/about');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class FrontendController extends Controller
{
    public function index()
    {
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
}

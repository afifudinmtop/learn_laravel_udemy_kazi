<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}

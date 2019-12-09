<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class PagesController extends Controller
{

    public function index()
    {
        return view('pages.index');
    }

    public function review(Request $request)
    {
        $data = $request->get('select_tag'); // 全データを連想配列で取得
        return view('pages.review')->with('data', $data);
    }

}

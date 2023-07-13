<?php

namespace App\Http\Controllers;

use App\Models\ShortURL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 *
 */
class ShortURLController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $shortURLs = ShortURL::latest()->take(10)->get();

        return view('welcome', compact('shortURLs'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'link' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        ShortURL::create([
            'destination_url' => $request->link,
            'url_key' => \App\Models\ShortURL::getUrlKey(),
        ]);

        $shortURLs = ShortURL::latest()->take(10)->get();

        return response()->json($shortURLs);
    }

    /**
     * @param $url_key
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function shortenUrl($url_key)
    {
        $find = ShortURL::where('url_key', $url_key)->first();

        return redirect($find->destination_url);
    }
}

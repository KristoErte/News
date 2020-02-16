<?php

namespace App\Http\Controllers;

use App\Article;

use App\Repository\Articles;
use Carbon\Carbon;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class ArticlesController extends Controller
{

    public function articles(Request $request) {

        $articles = Article::orderBy('date', 'DESC')->paginate(10);
        $url = request()->url();
        $queryParams = request()->query();
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $fullUrl = "{$url}?{$queryString}";

        $view = view('articles', compact('articles'))->render();
        return cache()->remember($fullUrl, Carbon::now()->addSeconds(5), function () use ($view) {
            return $view;
        });
    }

    public function loadMoreData(Request $request) {

        $page = $request->input('page');
        $articles = Article::skip((int)$page * 10)->orderBy('date', 'SORT_DESC')->paginate(10);
        $view = view('data', compact('articles'))->render();
        return cache()->remember($page, Carbon::now()->addSeconds(5), function () use ($view) {
            return  response()->json(['html'=>$view]);
        });
    }

}

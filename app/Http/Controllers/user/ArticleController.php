<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Repositories\Eloquent\ArticleEloquentRepository;



class ArticleController extends Controller
{

    protected $articleRepository;

    public function __construct(
        ArticleEloquentRepository $articleRepository
    ) {
        $this->articleRepository = $articleRepository;
    }
    


    public function index(Request $request) {
        $filters = $this -> handleFilter($request);
        //dd($filters);

        if(count($filters) > 0) {
            $articles = $this -> articleRepository -> filterArticles(
                $filters['limit'] ?? 5, 
                $filters['sort_filter'] ?? null,
                $filters['search'] ?? null,
                $filters['cate_id'] ?? null,
            );
        }else {
            $articles  = $this -> articleRepository -> paginateWhereOrderBy([], 'updated_at','DESC', $request -> page ?? 1, 5, ['*']);
        }

        $current_filters = $request -> all();
        return view('user.article-list', compact('articles', 'current_filters'));
    }

    public function detail(Request $request) {

        $slug = $request -> slug;
        if (!empty($slug)) {
            $foundArticle = $this -> articleRepository -> findBySlug($slug);
        }else {
            $foundArticle = null;
        }
        return view('user.article-detail', compact('foundArticle'));
    }


    public function handleFilter(Request $request) {
        $filterOptions = [
            'limit',
            'sort_filter',
            'search',
            'cate_id'
        ];
        
        $filterValue = [];
        
        foreach ($filterOptions as $key => $value) {
            if ($request->has($value)) {
                $filterValue[$value] = $request->input($value);
            }
        }
        return $filterValue;
    }
}

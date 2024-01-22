<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Eloquent\ProductEloquentRepository;
use App\Repositories\Eloquent\CategoryEloquentRepository;

class SearchController extends Controller
{

    protected $productRepository;
    protected $categoryRepository;

    public function __construct(
        ProductEloquentRepository $productRepository,
        CategoryEloquentRepository $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request) {

        

        $limit = $request -> limit ?? 20;
        $type = $request -> type ?? 'all';
        $sort = $request -> sort ?? 'latest';
        $search = $request -> search ?? null;
        $cate_list = $request -> categories ?? [];
        $author_list = $request -> authors ?? [];
        

        $products  = $this -> productRepository -> searchProducts($limit, $type, $sort, $search, $cate_list, $author_list);
        $products2 = $this -> productRepository -> searchProducts(1000, 'all', $sort, $search, $cate_list, $author_list);
        
        $categories = $this -> categoryRepository -> all();
        
        return view('user.search', compact('products', 'categories', 'authors', 'products2'));
    }
}

<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Eloquent\ProductEloquentRepository;
use App\Repositories\Eloquent\CategoryEloquentRepository;

class HomeController extends Controller
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

    function index(Request $request) {
        $filters = $this -> handleFilter($request);
        //dd($filters);

        if(count($filters) > 0) {
            $products = $this -> productRepository -> filterProducts(
                $filters['limit'] ?? 5, 
                $filters['sort_filter'] ?? null,
                $filters['search'] ?? null,
                $filters['cate_id'] ?? null,
            );
        }else {
            $products  = $this -> productRepository -> paginateWhereOrderBy(['status' => '1'], 'updated_at','DESC', $request -> page ?? 1, 5, ['*']);
        }

        $current_filters = $request -> all();
        return view('user.index', compact('products', 'current_filters'));
    }

    // Handle Filter Product
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

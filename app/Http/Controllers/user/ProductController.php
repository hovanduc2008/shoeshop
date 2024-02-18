<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\ProductEloquentRepository;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Spatie\PdfToImage\Pdf;
use Image;

class ProductController extends Controller
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

    public function detail(Request $request)
    {   
        $slug = $request -> slug;
        if (!empty($slug)) {
            $foundProduct = $this -> productRepository -> findBySlug($slug);
            if($foundProduct -> status != '1') $foundProduct = null;
        }else {
            $foundProduct = null;
        }
        return view('user.product-detail', compact('foundProduct'));
    }
}

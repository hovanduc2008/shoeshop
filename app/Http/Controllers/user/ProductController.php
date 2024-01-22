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
        

        return view('user.product-detail');
    }

    public function readbook(Request $request)
    {    
        $pdfUrl = 'http://localhost:8000/storage/uploads/pdf_file/Ngoi-khoc-tren-cay.pdf';

        return response() -> make('', 302)->header('Location', $pdfUrl)->header('Content-Type', '');
    }
}

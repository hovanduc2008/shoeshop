<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\ProductEloquentRepository;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Illuminate\Support\Facades\DB;
use Spatie\PdfToImage\Pdf;
use Image;

use App\Models\Review;

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

    public function getSuggestProducts($cate_id, $product_id) {
        $sql = "SELECT * FROM products WHERE category_id = '$cate_id'  AND status = 1 AND id != '$product_id' ORDER BY hot desc LIMIT 5 ";
        // $sql = "SELECT * FROM products WHERE category_id = '$cate_id'  LIMIT 5";
        return DB::select($sql);
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

        if(!empty($foundProduct)) $suggestProducts = $this -> getSuggestProducts($foundProduct -> category_id, $foundProduct -> id);
        else $suggestProducts = null;


        $reviews = Review::where('product_id', $foundProduct -> id) 
                ->get();

        $total_star = 0;

        foreach($reviews as $review) {
            $total_star += $review->rating;
        }

        $star_avg = count($reviews) > 0 ? round($total_star / count($reviews)) : 0;

        if(auth() -> guard('web') -> check())
        $reviewself = Review::where('product_id', $foundProduct -> id) 
                -> where('user_id', auth() -> guard('web') -> user() -> id)
                ->first();
        else 
        $reviewself = null;


        return view('user.product-detail', compact('foundProduct', 'reviews', 'reviewself', 'star_avg', 'suggestProducts'));
    }

    public function handleReview(Request $request) {
        if(!empty($request->id)) {
            DB::table('reviews')
            ->where('id', $request->id)
            ->update([
                'rating' => $request->star ?? '4',
                'review_title' => $request->review_title ?? 'Tốt',
                'review_content' => $request->review_content ?? '',
                'created_at' => date('Y-m-d H:i')
            ]);
        }else {
            Review::insert([
                'user_id' => auth() -> guard('web') -> user() -> id,
                'product_id' => $request -> product_id,
                'rating' => $request -> rating ?? '4',
                'review_title' => $request -> review_title ?? 'Tốt',
                'review_content' => $request -> review_content ?? '',
            ]);
        }

        return redirect() -> back();
    }


    public function setFavourite(Request $request) {
        if(auth() -> guard('web') -> check()) {
            $slug = $request -> slug;
            $foundProduct = $this -> productRepository -> findBySlug($slug);
            if(!empty($foundProduct)) {
                $foundFavourite = DB::table('favourites') 
                -> where('product_id', $foundProduct -> id)
                -> where('user_id', auth() -> guard('web') -> user() -> id) -> first();
                if(!empty($foundFavourite)) {
                    DB::table('favourites')->where('id', $foundFavourite->id)->delete();
                }else {
                    DB::table('favourites') -> insert([
                        'user_id' => auth() -> guard('web') -> user() -> id,
                        'product_id' => $foundProduct -> id
                    ]);
                }
            }
            return redirect() -> back();
        }
        else return redirect() -> route('login-form');
    }
}

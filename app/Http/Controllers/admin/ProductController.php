<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Eloquent\ProductEloquentRepository;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Validator;

use App\Http\Controllers\ImageController;

class ProductController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;
    

    public function __construct(
        ProductEloquentRepository $productRepository,
        CategoryEloquentRepository $categoryRepository) {
        
        $this -> productRepository = $productRepository;
        $this -> categoryRepository = $categoryRepository;
    }

    public function index(Request $request) {    
        $filters = $this -> handleFilter($request);
        if(count($filters) > 0) {
            $products = $this -> productRepository -> filterProducts(
                $filters['limit'] ?? 5, 
                $filters['sort_filter'] ?? null,
                $filters['search'] ?? null,
                $filters['author_id'] ?? null,
                $filters['cate_id'] ?? null,
            );
        }else {
            $products  = $this -> productRepository -> paginateWhereOrderBy([], 'updated_at','DESC', $request -> page ?? 1, 5, ['*']);
        }

        $current_filters = $request -> all();
        return view('admin.products.index', compact('products', 'current_filters'));
    }

    


    // Create Product
    public function createForm() {
        $categories = $this -> categoryRepository -> all();

        return view('admin.products.create', compact('categories'));
    }

    public function handleCreate(Request $request,ImageController $img) {
        $validated = $request -> validate([
            'title' => 'required',
            'price' => 'required|integer',
        ]);

        $request -> merge($img -> upload($request));

        $data = $request -> merge(
            [
                'added_by' => auth('web') -> id(),
                'slug' => Str::slug($request -> title),
                'category_id' => $request -> category,
                'author_id' => $request -> author,
                'discount' => $request -> discount ?? 0
            ]
        ) -> all();

       

        $this -> productRepository -> create($data);

        return redirect() -> route('admin.products') -> with('success', 'Tạo thành công sách');
    }



    // Edit Product
    public function editForm(Request $request) {
        $categories = $this -> categoryRepository -> all();
        $foundProduct = $this -> productRepository -> findById($request -> id);

        return view('admin.products.edit', compact('categories', 'foundProduct'));
    }

    public function handleEdit(Request $request, ImageController $img) {
        
        $validated = $request -> validate([
            'title' => 'required',
            'price' => 'required|integer'
        ]);

        $foundProduct = $this -> productRepository -> findById($request -> id);

        $request -> merge([
            'slug' => Str::slug($request -> title),
            'author_id' => $request -> author,
            'category_id' => $request -> category,
            'status' => !empty($request -> status) ? '1' : '0',
            'hot' => !empty($request -> hot) ? '1' : '0',
            'discount' => $request -> discount
        ]);

        $hasFileImage = $request -> hasFile('upload_image');
        $hasFileThumbnail = $request -> hasFile('upload_thumbnail');

        if($hasFileImage || isset($request -> is_delete)) {
            $img -> remove($foundProduct -> image);
        }
        if($hasFileThumbnail) {
            $img -> remove($foundProduct -> thumbnail);   
        }
        $request -> merge($img -> upload($request));

        if(isset($request -> is_delete)) {
            $request -> merge([
                'image' => '',
            ]);
        }



        $this -> productRepository ->update($request -> all(), $foundProduct -> id);

        return redirect() -> route('admin.product.edit', $foundProduct -> id) -> with('success', 'Updated product');
    }


    // Delete Product
    public function handleDelete(Request $request, ImageController $img) {
        $id = $request -> id;
        $foundProduct = $this -> productRepository -> findById($id);
        // $img -> remove($foundProduct -> image);

        // $this -> productRepository -> delete($id);
        $foundProduct -> delete();
        return redirect() -> route('admin.products') -> with('success', 'Xóa thành công product');
    }



    // Handle Filter Product
    public function handleFilter(Request $request) {
        $filterOptions = [
            'limit',
            'sort_filter',
            'search',
            'author_id',
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

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Controllers\ImageController;

use App\Repositories\Eloquent\ArticleEloquentRepository;

class ArticleController extends Controller
{

    protected $articleRepository;

    public function __construct(
        ArticleEloquentRepository $articleRepository
    ) {
        $this -> articleRepository = $articleRepository;
    }

    public function index(Request $request) {
        
        $filters = $this -> handleFilter($request);
        if(count($filters) > 0) {
            $articles = $this -> articleRepository -> filterArticles(
                $filters['limit'] ?? 5, 
                $filters['sort_filter'] ?? 'latest',
                $filters['search'] ?? null
            );
        }else {
            $articles  = $this -> articleRepository -> paginateWhereOrderBy([], 'updated_at','DESC', $request -> page ?? 1, 5, ['*']);
        }
        $current_filters = $request -> all();
        return view('admin.articles.index', compact('articles', 'current_filters'));
    }

    public function createForm() {
        return view('admin.articles.create');
    }

    public function handleCreate(Request $request, ImageController $img) {

        $validated = $request -> validate([
            'title' => 'required'
        ]);

        $request -> merge($img -> upload($request));  

        $data = $request -> merge(
            [
                'added_by' => auth('web') -> id(),
                'slug' => Str::slug($request -> title)
            ]
        ) -> all();

        $this -> articleRepository -> create($data);

        return redirect() -> route('admin.articles') -> with(['success' => "Thêm thành công danh mục: ".$request -> title."!"]);
    }

    public function editForm(Request $request) {
        $foundArticle = $this -> articleRepository -> findById($request -> id);
        return view('admin.articles.edit', compact('foundArticle'));
    }

    // Xử lý sửa danh mục
    public function handleEdit(Request $request, ImageController $img) {
        $validator = $request -> validate([
            'title' => 'required',
        ]);

        $foundArticle = $this -> articleRepository -> findById($request -> id);

        $hasFileImage = $request -> hasFile('upload_image');
        $hasFileThumbnail = $request -> hasFile('upload_thumbnail');

        if($hasFileImage || isset($request -> is_delete)) {
            $img -> remove($foundArticle -> image);
        }
        if($hasFileThumbnail) {
            $img -> remove($foundArticle -> thumbnail);   
        }
        $request -> merge($img -> upload($request));

        if(isset($request -> is_delete)) {
            $request -> merge([
                'image' => '',
            ]);
        }

        $this -> articleRepository -> update($request -> all(), $foundArticle -> id);

        return redirect() -> route('admin.article.edit', $foundArticle -> id) -> with('success', 'Updated article');
    }

    public function handleDelete(Request $request, ImageController $img) {
        $id = $request -> id;
        $foundArticle = $this -> articleRepository -> findById($id);
        $foundArticle -> delete();
        return redirect() -> route('admin.articles') -> with('success', 'Xóa thành công bài viết '.$foundArticle -> title);
    }

    public function handleFilter(Request $request) {
        $filterOptions = [
            'limit',
            'sort_filter',
            'search'
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

<?php
namespace App\Repositories\Eloquent;

use App\Repositories\BaseEloquentRepository;
use App\Models\Article;

class ArticleEloquentRepository extends BaseEloquentRepository {
    public function model() {
        return Article::class;
    }

    public function filterArticles($limit ,$sort_filter, $search) {
        $query = $this->model->select('articles.*');
    
        if ($search) {
            $query = $query->where(function($query) use ($search) {
                $query->orWhere('id',"like",  "%$search%")
                    ->orWhere("title", "like", "%$search%");
            });
        }
    
        if ($sort_filter) {
            switch ($sort_filter) {
                case 'latest':
                    $query = $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query = $query->orderBy('created_at', 'asc');
                    break;
                case 'a_z':
                    $query = $query->orderBy('title', 'asc');
                    break;
                case 'z_a':
                    $query = $query->orderBy('title', 'desc');
                    break;
                default:
                    break;
            }
        }
    
        $results = $query->paginate($limit);
    
        return $results;
    }
}
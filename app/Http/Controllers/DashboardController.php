<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Page;
use App\Models\Post;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'cards' => [
                'categories' => Category::count(),
                'comments' => Comment::count(),
                'posts' => Post::count(),
                'pages' => Page::count(),
            ],
            'visitors' => $this->prepareVisitors(),
            'comments' =>  CommentResource::collection(Comment::with('post')->latest()->limit(5)->get()),
        ]);
    }

    /**
     * @return array
     */
    private function prepareVisitors(): array
    {
        return Visitor::select(
            DB::raw("DATE_FORMAT(visited_at, '%b') as month"),
            DB::raw("(COUNT(*)) as value")
        )->whereYear('visited_at', date('Y'))->groupBy('month')->get()->toArray();
    }
}

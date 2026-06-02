<?php

namespace App\Http\Controllers\Api\Blog;


use App\Repositories\BlogPostRepository;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    public function __construct(private BlogPostRepository $blogPostRepository)
    {
        // parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate();

        return $paginator;
    }

    public function store(Request $request) { }
    public function update(Request $request, string $id) { }
    public function destroy(string $id) { }
}

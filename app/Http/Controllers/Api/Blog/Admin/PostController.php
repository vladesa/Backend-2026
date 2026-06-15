<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Repositories\BlogPostRepository;
use App\Repositories\BlogCategoryRepository;
use App\Http\Requests\BlogPostUpdateRequest;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Http\Requests\BlogPostCreateRequest;
use App\Jobs\BlogPostAfterCreateJob;
use App\Jobs\BlogPostAfterDeleteJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

// 🔥 1. Підключаємо наш новий ресурс (як вимагає крок 3)
use App\Http\Resources\Api\Blog\Admin\PostResource;

class PostController extends BaseController
{
    use DispatchesJobs;

    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogCategoryRepository $blogCategoryRepository
    ) {
        // parent::__construct();
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $search = $request->query('search', '');

        // Отримуємо пагіновані дані з репозиторія
        $paginator = $this->blogPostRepository->getAllWithPaginate($perPage, $search);

        // 🔥 2. Обгортаємо пагінацію в API Ресурс замість звичайного response()->json()
        return PostResource::collection($paginator);
    }

    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();

        $item = (new BlogPost())->create($data);

        if ($item) {
            $job = new BlogPostAfterCreateJob($item);
            $this->dispatch($job);

            return ['success' => true, 'message' => 'Успішно збережено', 'data' => $item];
        } else {
            return ['success' => false, 'message' => 'Помилка збереження'];
        }
    }

    public function show(string $id)
    {
        $item = BlogPost::find($id);

        if (!$item) {
            return response()->json(['message' => "Запис id=[{$id}] не знайдено"], 404);
        }

        // 🔥 3. Обгортаємо окрему статтю в API Ресурс
        return new PostResource($item);
    }

    public function update(BlogPostUpdateRequest $request, string $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)) {
            return ['message' => "Запис id=[{$id}] не знайдено"];
        }

        $data = $request->all();

        $result = $item->update($data);

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data'    => $item
            ];
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }

    public function destroy(string $id)
    {
        $result = BlogPost::destroy($id);

        if ($result) {
            BlogPostAfterDeleteJob::dispatch($id)->delay(20);
            return ['success' => true, 'message' => "Запис id=[{$id}] успішно видалено"];
        } else {
            return ['success' => false, 'message' => 'Помилка видалення'];
        }
    }
}

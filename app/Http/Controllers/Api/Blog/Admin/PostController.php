<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Repositories\BlogPostRepository;
use App\Repositories\BlogCategoryRepository;
use App\Http\Requests\BlogPostUpdateRequest;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Http\Requests\BlogPostCreateRequest;

class PostController extends BaseController
{
    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogCategoryRepository $blogCategoryRepository
    ) {
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input(); // отримаємо масив даних, які надійшли з форми

        $item = (new BlogPost())->create($data); // створюємо об'єкт і додаємо в БД

        if ($item) {
            return ['success' => true, 'message' => 'Успішно збережено', 'data' => $item];
        } else {
            return ['success' => false, 'message' => 'Помилка збереження'];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogPostUpdateRequest $request, string $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)) { //якщо ід не знайдено
            return ['message' => "Запис id=[{$id}] не знайдено"];
        }

        $data = $request->all(); //отримаємо масив даних, які надійшли з форми



        $result = $item->update($data); //оновлюємо дані об'єкта і зберігаємо в БД

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data'    => $item // ОЦЕЙ РЯДОК ПОВЕРНЕ ВСІ ДАНІ СТАТТІ!
            ];
        }
        else {
            return ['message' => 'Помилка збереження'];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = BlogPost::destroy($id); // софт деліт, запис лишається в БД, але не виводиться

        if ($result) {
            return ['success' => true, 'message' => "Запис id=[{$id}] успішно видалено"];
        } else {
            return ['success' => false, 'message' => 'Помилка видалення'];
        }
    }
}

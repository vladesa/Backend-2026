<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Support\Str;
use App\Http\Resources\Api\Blog\Admin\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function __construct(private BlogCategoryRepository $blogCategoryRepository)
    {
        // parent::__construct();
    }

    // 🔥 ЗМІНЕНО: Тепер метод приймає Request від нашого Nuxt
    public function index(Request $request)
    {
        // Витягуємо параметри пошуку та пагінації (за замовчуванням 15)
        $perPage = $request->query('per_page', 15);
        $search = $request->query('search', '');

        // Передаємо їх у репозиторій, щоб база даних відфільтрувала результат
        $paginator = $this->blogCategoryRepository->getAllWithPaginate($perPage, $search);

        return CategoryResource::collection($paginator);
    }

    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        $item = (new BlogCategory())->create($data);

        if ($item) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => $item
            ];
        } else {
            return response()->json(['message' => 'Помилка збереження'], 500);
        }
    }


    public function show(string $id)
    {
        $item = BlogCategory::find($id);

        if (!$item) {
            return response()->json(['message' => "Запис id=[{$id}] не знайдено"], 404);
        }

        return new CategoryResource($item);
    }

    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);


        if (empty($item)) {
            return response()->json(['message' => "Запис id=[{$id}] не знайдено"], 404);
        }

        $data = $request->all();
        $result = $item->update($data);

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно оновлено',
                'data' => $item
            ];
        } else {
            return response()->json(['message' => 'Помилка збереження'], 500);
        }
    }


    public function destroy(string $id)
    {
        $result = BlogCategory::destroy($id);

        if ($result) {
            return ['success' => true, 'message' => "Категорію id=[{$id}] успішно видалено"];
        } else {
            return response()->json(['message' => 'Помилка видалення'], 500);
        }
    }
}

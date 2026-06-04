<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Support\Str;

//use Illuminate\Http\Request;


class CategoryController extends BaseController
{
    public function __construct(private BlogCategoryRepository $blogCategoryRepository)
    {
        // parent::__construct();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$paginator = BlogCategory::paginate(5);
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(5);
        return $paginator;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input(); // отримуємо масив даних, які надійшли з форми



        $item = (new BlogCategory())->create($data); // створюємо об'єкт і додаємо в БД

        if ($item) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => $item // Залишаємо вивід даних, бо це круто!
            ];
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) { // якщо id не знайдено
            return back()
                ->withErrors(['msg' => "Запис id=[{$id}] не знайдено"])
                ->withInput();
        }

        $data = $request->all(); // отримаємо масив даних



        $result = $item->update($data); // оновлюємо дані

        if ($result) {
            return [
                'success' => 'Успішно збережено',
                'data' => $item
            ];
        } else {
            return ['msg' => 'Помилка збереження'];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}

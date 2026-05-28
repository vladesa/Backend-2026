<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Models\BlogCategory;
use Illuminate\Support\Str;
//use Illuminate\Http\Request;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Requests\BlogCategoryCreateRequest;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = BlogCategory::paginate(5);
        return $paginator;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input(); // отримуємо масив даних, які надійшли з форми

        if (empty($data['slug'])) { // якщо псевдонім порожній
            $data['slug'] = \Illuminate\Support\Str::slug($data['title']); // генеруємо псевдонім
        }

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
        $item = BlogCategory::find($id);

        if (empty($item)) { // якщо id не знайдено
            return back()
                ->withErrors(['msg' => "Запис id=[{$id}] не знайдено"])
                ->withInput();
        }

        $data = $request->all(); // отримаємо масив даних

        if (empty($data['slug'])) { // якщо псевдонім порожній
            $data['slug'] = Str::slug($data['title']);
        }

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

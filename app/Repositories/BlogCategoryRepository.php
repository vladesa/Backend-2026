<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BlogСategoryRepository.
 */
class BlogCategoryRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class; //абстрагування моделі BlogCategory, для легшого створення іншого репозиторія
    }

    /**
     * Отримати модель для редагування в адмінці
     * @param int $id
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Отримати список категорій для виводу в випадаючий список
     * @return Collection
     */
    public function getForComboBox()
    {
        $columns = implode(', ', [
            'id',
            'CONCAT (id, ". ", title) AS id_title', //додаємо поле id_title
        ]);

        $result = $this                           //2 варіант
        ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();

        return $result;
    }


    public function getAllWithPaginate($perPage = null, $search = '')
    {
        $columns = ['id', 'title', 'parent_id'];

        $query = $this
            ->startConditions()
            ->select($columns)
            ->with(['parentCategory:id,title']);

        // Якщо користувач ввів щось у пошук, додаємо умову
        if (!empty($search)) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }

        return $query->paginate($perPage);
    }
}

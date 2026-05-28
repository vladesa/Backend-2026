<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Carbon\Carbon;

class DiggingDeeperController extends Controller
{

    public function collections()
    {
        $result = [];

        /**
         * @var \Illuminate\Database\Eloquent\Collection $eloquentCollection
         */
        $eloquentCollection = BlogPost::withTrashed()->get();

        // 1. ПЕРШИЙ ТЕСТ: Розкоментуйте рядок нижче, щоб перевірити
        //dd(__METHOD__, $eloquentCollection, $eloquentCollection->toArray());

        /**
         * @var \Illuminate\Support\Collection $collection
         */
        $collection = collect($eloquentCollection->toArray());

        // 2. ДРУГИЙ ТЕСТ: Розкоментуйте блок нижче
        /* dd(
            get_class($eloquentCollection),
            get_class($collection),
            $collection
        ); */

        $result['first'] = $collection->first(); // вибираємо 1 елемент
        $result['last'] = $collection->last(); // вибираємо останній елемент

        $result['where']['data'] = $collection
            ->where('category_id', 10) // вибираємо елементи з категорією 10
            ->values() // беремо лише значення без ключів
            ->keyBy('id'); // прирівнюємо id з бд з ключем масива

        $result['where']['count'] = $result['where']['data']->count();
        $result['where']['isEmpty'] = $result['where']['data']->isEmpty();
        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty();

        if ($result['where']['data']->isNotEmpty()) {
            //
        }

        $result['where_first'] = $collection
            ->firstWhere('created_at', '>', '2020-02-24 03:46:16');

        // Базова змінна не змінюється. Вертаємо змінену версію.
        $result['map']['all'] = $collection->map(function ($item) {
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);

            return $newItem;
        });

        $result['map']['not_exists'] = $result['map']['all']->where('exists', '=', false)->values()->keyBy('item_id');

        // 3. ТРЕТІЙ ТЕСТ: Розкоментуйте рядок нижче
        // dd($result);

        // Базова змінна змінюється (трансформується).
        $collection->transform(function ($item) {
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            $newItem->created_at = Carbon::parse($item['created_at']);

            return $newItem;
        });

        // 4. ЧЕТВЕРТИЙ ТЕСТ: Розкоментуйте рядок нижче
        // dd($collection);


        /* === ЦЕЙ БЛОК ЗАКРИТО ЩОБ НЕ ЛАМАТИ НАСТУПНІ ФІЛЬТРИ ===
        $newItem = new \stdClass();
        $newItem->id = 9999;

        $newItem2 = new \stdClass();
        $newItem2->id = 8888;

        // Додаємо елемент в початок/кінець колекції
        $newItemFirst = $collection->prepend($newItem)->first(); // додали в початок
        $newItemLast = $collection->push($newItem2)->last(); // додали в кінець
        $pulledItem = $collection->pull(1); // забрали з першим ключем

        // 5. П'ЯТИЙ ТЕСТ
        // dd(compact('collection', 'newItemFirst', 'newItemLast', 'pulledItem'));
        ======================================================== */


        // Фільтрація
        $filtered = $collection->filter(function ($item) {
            $byDay = $item->created_at->isFriday(); // питаємо Carbon
            $byDate = $item->created_at->day == 11;

            $result = $byDay && $byDate;
            return $result;
        });

        // 6. ШОСТИЙ ТЕСТ: Тепер він запрацює без помилок!
        // dd(compact('filtered'));

        $sortedSimpleCollection = collect([5, 3, 1, 2, 4])->sort()->values();
        $sortedAscCollection = $collection->sortBy('created_at');
        $sortedDescCollection = $collection->sortByDesc('item_id');

        // 7. СЬОМИЙ ТЕСТ: Останній крок
        // dd(compact('sortedSimpleCollection', 'sortedAscCollection', 'sortedDescCollection'));
    }
}

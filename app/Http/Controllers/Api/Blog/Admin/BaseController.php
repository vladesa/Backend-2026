<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Controllers\Controller; // <--- ЦЕЙ РЯДОК ДУЖЕ ВАЖЛИВИЙ!

class BaseController extends Controller
{
    public function __construct()
    {
        // Ініціалізація загальних елементів адмінки
    }
}

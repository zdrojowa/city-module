<?php

namespace Selene\Modules\CityModule\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Selene\Modules\CityModule\Models\City;

class ApiController extends Controller
{
    public function get(): JsonResponse
    {
        return response()->json(City::query()->orderBy('order')->get());
    }
}

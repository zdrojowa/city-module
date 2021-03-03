<?php

namespace Selene\Modules\CityModule\Http\Controllers;

use Illuminate\Routing\Controller;
use Selene\Modules\CityModule\Models\City;
use Selene\Modules\LanguageModule\Models\Language;

class CityController extends Controller
{
    public function index()
    {
        return view('CityModule::index');
    }

    public function create()
    {
        return view('CityModule::edit', [
            'langs' => Language::getAllSelect(),
        ]);
    }

    public function edit(City $city = null)
    {
        return view('CityModule::edit', [
            'city'  => $city,
            'langs' => Language::getAllSelect(),
        ]);
    }

    public function sort()
    {
        return view('CityModule::sort', [
            'cities' => City::query()->orderBy('order')->select(['name', 'id'])->get()
        ]);
    }
}

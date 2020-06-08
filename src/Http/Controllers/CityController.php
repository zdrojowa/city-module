<?php

namespace Selene\Modules\CityModule\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Selene\Modules\DashboardModule\ZdrojowaTable;
use Selene\Modules\CityModule\Models\City;

class CityController extends Controller
{
    public function index()
    {
        return view('CityModule::list');
    }

    public function sort()
    {
        return view('CityModule::sort');
    }

    public function ajax(Request $request): JsonResponse
    {
        return ZdrojowaTable::response(City::query(), $request);
    }

    public function create()
    {
        return view('CityModule::edit');
    }

    public function edit(City $city = null)
    {
        return view('CityModule::edit', ['city' => $city]);
    }

    public function store(Request $request): RedirectResponse
    {
        $city = $this->save($request);
        if ($city) {
            $request->session()->flash('alert-success', 'Miasto pomyślnie dodano');
            return redirect()->route('CityModule::edit', ['city' => $city]);
        }

        $request->session()->flash('alert-error', 'Ooops. Try again.');
        return redirect()->back();
    }

    public function update(Request $request, City $city): RedirectResponse
    {
        if ($this->save($request, $city)) {
            $request->session()->flash('alert-success', 'Miasto zostało pomyślnie zaktualizowano.');
        } else {
            $request->session()->flash('alert-error', 'Ooops. Try again.');
        }

        return redirect()->back();
    }

    private function save(Request $request, City $city = null) {
        if ($city === null) {
            $request->merge(['order' => City::query()->count() + 1]);
            return City::create($request->all());
        }

        return $city->update($request->all());
    }

    public function destroy(City $city, Request $request): void
    {
        try {
            $city->delete();
            $request->session()->flash('alert-success', 'Miasto jest usunięte');
        } catch (Exception $e) {
            $request->session()->flash('alert-error', 'Error: ' . $e->getMessage());
        }
    }

    public function saveOrder(Request $request)
    {
        $list = json_decode($request->get('list'), true);
        foreach ($list as $i => $city) {
            City::query()->where('_id', '=', $city['_id'])->update(['order' => $i + 1]);
        }
        return ['redirect' => route('CityModule::list')];
    }
}

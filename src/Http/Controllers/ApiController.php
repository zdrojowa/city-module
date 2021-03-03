<?php

namespace Selene\Modules\CityModule\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Selene\Modules\CityModule\Models\City;

class ApiController extends Controller
{
    public function get(): JsonResponse
    {
        return response()->json(City::query()->orderBy('order')->get());
    }

    public function check(Request $request): JsonResponse
    {
        $name = $request->get('name');
        if (empty($name)) {
            return response()->json([
                'message' => 'Name is required'
            ],JsonResponse::HTTP_BAD_REQUEST);
        }

        $exists = City::query()->where('name', '=', $name);
        if ($request->has('id')) {
            $exists->where('_id', '!=', $request->get('id'));
        }
        return response()->json(!$exists->exists());
    }

    public function store(Request $request): JsonResponse
    {
        $city = $this->save($request);
        if ($city) {
            return response()->json([
                'redirect' => route('CityModule::edit', ['city' => $city])
            ]);
        }

        return response()->json([
            'message' => 'Oops. Try again'
        ]);
    }

    public function update(Request $request, City $city): JsonResponse
    {
        if ($this->save($request, $city)) {
            return response()->json([
                'redirect' => route('CityModule::edit', ['city' => $city])
            ]);
        }

        return response()->json([
            'message' => 'Oops. Try again'
        ]);
    }

    private function save(Request $request, City $city = null) {
        foreach ($request->all() as $key => $val) {
            if ($val === 'null' || $val == '') {
                $request->merge([$key => null]);
            }
        }

        $fields = ['image', 'gallery', 'titles', 'labels', 'descriptions'];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                $value = $request->get($field);
                if (!empty($value)) {
                    $value = json_decode($value, false, 512, JSON_THROW_ON_ERROR);
                }
                if (empty($value)) {
                    $request->merge([$field => null]);
                } else {
                    $request->merge([$field => $value]);
                }
            }
        }

        if ($city === null) {
            $request->merge(['order' => City::query()->count() + 1]);
            return City::query()->create($request->all());
        }

        return $city->update($request->all());
    }

    public function remove(City $city): JsonResponse
    {
        try {
            if (!$city->delete()) {
                throw new \Exception('Cannot remove city');
            }
            return response()->json(['message' => 'Miasto usunięte']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()],JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    public function sort(Request $request): JsonResponse
    {
        $list = json_decode($request->get('list'), true);
        foreach ($list as $i => $city) {
            City::query()->where('_id', '=', $city['id'])->update(['order' => $i + 1]);
        }
        return response()->json(['redirect' => route('CityModule::index')]);
    }
}

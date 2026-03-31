<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\City\CityCollection;
use App\Http\Resources\Api\V1\Province\ProvinceCollection;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::active()->orderBy('ordering')->get();

        return $this->respondWithResourceCollection(new ProvinceCollection($provinces));
    }

    public function cities(Province $province)
    {
        $cities = $province->cities()
            ->active()
            ->orderBy('ordering')
            ->get();

        return $this->respondWithResourceCollection(new CityCollection($cities));
    }
}

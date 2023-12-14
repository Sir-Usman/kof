<?php

namespace App\Http\Controllers\api\v2;

use App\Http\Controllers\Controller;
use App\Model\City;

class CityController extends Controller
{
    public function getCities()
    {
        try {
          $cities = City::all();
        } catch (\Exception $e) {

        }

        return response()->json($cities,200);
    }
}

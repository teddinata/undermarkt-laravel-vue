<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class LocationController extends Controller
{
    public function provinces(Request $request)
    {
        return Province::all();
    }

    public function regencies(Request $request, $provinces_id)
    {
        return Regency::where('province_id', $provinces_id)->get();
    }

    public function districts(Request $request, $regencies_id)
    {
        return District::where('regency_id', $regencies_id)->get();
    }

    public function villages(Request $request, $districts_id)
    {
        return Village::where('district_id', $districts_id)->get();
    }
}

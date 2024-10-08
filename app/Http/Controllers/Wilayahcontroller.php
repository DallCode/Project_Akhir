<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    // Mengambil data provinsi
    public function getProvinces()
    {
        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        return response()->json($response->json());
    }

    // Mengambil data kota berdasarkan provinsi
    public function getCities($provinceId)
    {
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinceId}.json");
        return response()->json($response->json());
    }
}

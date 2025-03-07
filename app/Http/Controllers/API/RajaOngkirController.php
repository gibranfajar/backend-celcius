<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY');
        $this->baseUrl = env('RAJAONGKIR_BASE_URL');
    }

    // Ambil daftar provinsi
    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . 'province');

        return response()->json([
            'data' => $response->json()['rajaongkir']['results']
        ]);
    }

    // Ambil daftar kota berdasarkan provinsi
    public function getCities($provinceId)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . 'city', [
            'province' => $provinceId
        ]);

        return response()->json([
            'data' => $response->json()['rajaongkir']['results']
        ]);
    }

    // Ambil daftar kecamatan (hanya tersedia di RajaOngkir Pro)
    public function getSubdistricts($cityId)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . 'subdistrict', [
            'city' => $cityId
        ]);

        return response()->json([
            'data' => $response->json()['rajaongkir']['results']
        ]);
    }

    // Cek ongkos kirim (bisa ke luar negeri di versi Pro)
    public function getCost(Request $request)
    {
        $request->validate([
            'origin'      => 'required|integer',
            'destination' => 'required|integer',
            'weight'      => 'required|integer',
            'courier'     => 'required|string',
            'originType'  => 'required|string', // city atau subdistrict
            'destType'    => 'required|string'  // city atau subdistrict
        ]);

        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->post($this->baseUrl . 'cost', [
            'origin'      => $request->origin,
            'originType'  => $request->originType,
            'destination' => $request->destination,
            'destinationType' => $request->destType,
            'weight'      => $request->weight,
            'courier'     => $request->courier
        ]);

        // hilangkan service gokil dan response nya berupa array
        $filteredServices = array_filter($response->json()['rajaongkir']['results'][0]['costs'], function ($service) {
            return $service['service'] !== 'GOKIL';
        });

        return response()->json([
            'data' => array_values($filteredServices)
        ]);
    }

    // Lacak resi (waybill)
    public function trackShipment(Request $request)
    {
        $request->validate([
            'waybill' => 'required|string',
            'courier' => 'required|string'
        ]);

        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->post($this->baseUrl . 'waybill', [
            'waybill' => $request->waybill,
            'courier' => $request->courier
        ]);

        return response()->json($response->json());
    }
}

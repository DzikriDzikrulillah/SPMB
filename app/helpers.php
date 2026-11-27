<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

if (! function_exists('dateIndo')) {
    function dateIndo($variabel)
    {
        $month = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        return $variabel->created_at->format("j") . " " . $month[$variabel->created_at->format("n") - 1] . " " . $variabel->created_at->format("Y");
    }
}

if (!function_exists('getAPI')) {
    function getAPI()
    {
        $response = Http::get('https://api-sekolah-indonesia.vercel.app/sekolah/SMP?kab_kota=022100&page=1&perPage=100');
        $data = (array) $response->json('dataSekolah');

        return $data;
    }
}
if (!function_exists('imageUrl')) {
    function imageUrl(int $width = 200, int $height = 200)
    {
        $baseUrl = 'https://loremflickr.com';
        $url = "{$baseUrl}/{$width}/{$height}";

        // $response = Http::get($baseUrl);
        // return $response->body();
        return $url;
    }
}

if (!function_exists('timestampToAgo')) {
    function timestampToAgo($timestamp)
    {
        return Carbon::parse($timestamp)->ago();
    }
}

if (! function_exists('haversine_distance_km')) {
    function haversine_distance_km($lat1, $lon1, $lat2, $lon2)
    {
        // convert to float
        $lat1 = (float) $lat1;
        $lon1 = (float) $lon1;
        $lat2 = (float) $lat2;
        $lon2 = (float) $lon2;

        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = $earthRadius * $c;

        return round($d, 2);
    }
}

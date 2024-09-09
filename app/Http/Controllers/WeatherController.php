<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WeatherController extends Controller
{
   public  function getWeather(Request $request)
   {
      try {
         $lat = $request->input("lat");
         $lon = $request->input("lon");
         $apiKey = env("OPENWEATHER_API_KEY");
         $url = "http://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$apiKey}&units=metric";
         $client = new Client();
         $response = $client->get($url);
         $weatherData = json_decode($response->getBody()->getContents(), true);
         return response()->json([
            'success' => true,
            'data' => $weatherData
         ]);
      } catch (\Exception $e) {
         print_r($e);
         return response()->json([
            'success' => false,
            'message' => 'Error fetching weather data',
         ], 500);
      }
   }
}
